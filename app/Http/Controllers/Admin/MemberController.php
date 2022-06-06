<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use App\Models\Discount;
use App\Models\User;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

class MemberController extends Controller
{
    public function index()
    {
        $groups = @getGroupsByRole();
        $blanks = config('constants.blanks');

        return view('admin.pages.members.index', compact('groups', 'blanks'));
    }

    public function create(Request $request, Group $group)
    {
        $docs            = Doc::get();
        $discounts       = Discount::get();
        $basicSeatsLimit = $group->basic_seats;
        $extraSeatsLimit = $group->extra_seats;
        $basicSeatsExist = $group->members->where('form_study', 0)->count();
        $extraSeatsExist = $group->members->where('form_study', 1)->count();

        // access to free seats
        if ($basicSeatsExist < $basicSeatsLimit) {
            $form_study = config('constants.form_education')[0];
        }

        // access to paid seats
        elseif ($basicSeatsExist >= $basicSeatsLimit AND $extraSeatsExist < $extraSeatsLimit) {
            $form_study = config('constants.form_education')[1];
        }

        // group is full
        else {
            $request->session()->flash('warning', __('_dialog.group_full'));
            return redirect()->back();
        }

        return view('admin.pages.members.form', compact('group', 'docs', 'discounts', 'form_study'));
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');

        if (Auth::user()->role_id != 3) {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->back();
        }

        $doc_file           = $request->file('doc_file');
        $doc_file_name      = is_null($doc_file) ? null : $doc_file->getClientOriginalName();
        $doc_file_path      = is_null($doc_file) ? null : $doc_file->store('documents');

        $app_file           = $request->file('app_file');
        $app_file_name      = is_null($app_file) ? null : $app_file->getClientOriginalName();
        $app_file_path      = is_null($app_file) ? null : $app_file->store('documents');

        $consent_file       = $request->file('consent_file');
        $consent_file_name  = is_null($consent_file) ? null : $consent_file->getClientOriginalName();
        $consent_file_path  = is_null($consent_file) ? null : $consent_file->store('documents');

        $discount_file      = $request->file('discount_doc');
        $discount_file_name = is_null($discount_file) ? null : $discount_file->getClientOriginalName();
        $discount_file_path = is_null($discount_file) ? null : $discount_file->store('documents');

        $address_file       = $request->file('address_doc');
        $address_file_name  = is_null($address_file) ? null : $address_file->getClientOriginalName();
        $address_file_path  = is_null($address_file) ? null : $address_file->store('documents');

        $user = User::create([
            'username'      => @bk_rand('login', $request['last_name'], 5),
            'password'      => bcrypt($default_password),
            'role_id'       => 5,
        ]);

        // TODO: client
        $user->permissions()->attach([
            19, 20,
            31
        ]);

        Member::create([
            'user_id'       => $user->id,
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'group_id'      => $request['group_id'],
            'form_study'    => $request['form_study'],
            'doc_id'        => $request['doc_id'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'doc_file'      => $doc_file_path,
            'doc_note'      => $doc_file_name,
            'app_file'      => $app_file_path,
            'app_note'      => $app_file_name,
            'consent_file'  => $consent_file_path,
            'consent_note'  => $consent_file_name,
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'discount_id'   => $request['discount_id'],
            'discount_doc'  => $discount_file_path,
            'discount_note' => $discount_file_name,
            'address_doc'   => $address_file_path,
            'address_note'  => $address_file_name,
            'address_fact'  => $request['address_fact'],
            'activity'      => $request['activity'],
            'phone'         => $request['phone'],
            'email'         => $request['email'],
            'master'        => @command_master(Auth::user()->worker),
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.members.index');
    }

    public function show(Member $member)
    {
        return view('admin.pages.members.show', compact('member'));
    }

    public function edit(Request $request, Member $member)
    {
        $docs      = Doc::get();
        $discounts = Discount::get();

        return view('admin.pages.members.form', compact('member', 'docs', 'discounts'));
    }

    public function update(Request $request, Member $member)
    {
        $doc_file_name = $member->doc_note;
        $doc_file_path = $member->doc_file;

        if ($request->has('doc_file')) {
            Storage::delete($member->doc_file);
            $doc_file      = $request->file('doc_file');
            $doc_file_name = $doc_file->getClientOriginalName();
            $doc_file_path = $doc_file->store('documents');
        }

        $app_file_name = $member->app_note;
        $app_file_path = $member->app_file;

        if ($request->has('app_file')) {
            Storage::delete($member->app_file);
            $app_file      = $request->file('app_file');
            $app_file_name = $app_file->getClientOriginalName();
            $app_file_path = $app_file->store('documents');
        }

        $consent_file_name = $member->consent_note;
        $consent_file_path = $member->consent_file;

        if ($request->has('consent_file')) {
            Storage::delete($member->consent_file);
            $consent_file      = $request->file('consent_file');
            $consent_file_name = $consent_file->getClientOriginalName();
            $consent_file_path = $consent_file->store('documents');
        }

        $discount_file_name = $member->discount_note;
        $discount_file_path = $member->discount_doc;

        if ($request->has('discount_doc')) {
            Storage::delete($member->discount_doc);
            $discount_file      = $request->file('discount_doc');
            $discount_file_name = $discount_file->getClientOriginalName();
            $discount_file_path = $discount_file->store('documents');
        }

        $address_file_name = $member->address_note;
        $address_file_path = $member->address_doc;

        if ($request->has('address_doc')) {
            Storage::delete($member->address_doc);
            $address_file      = $request->file('address_doc');
            $address_file_name = $address_file->getClientOriginalName();
            $address_file_path = $address_file->store('documents');
        }

        $member->update([
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'doc_id'        => $request['doc_id'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'doc_file'      => $doc_file_path,
            'doc_note'      => $doc_file_name,
            'app_file'      => $app_file_path,
            'app_note'      => $app_file_name,
            'consent_file'  => $consent_file_path,
            'consent_note'  => $consent_file_name,
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'discount_id'   => $request['discount_id'],
            'discount_doc'  => $discount_file_path,
            'discount_note' => $discount_file_name,
            'address_doc'   => $address_file_path,
            'address_note'  => $address_file_name,
            'address_fact'  => $request['address_fact'],
            'activity'      => $request['activity'],
            'phone'         => $request['phone'],
            'email'         => $request['email'],
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.members.index');
    }

    public function destroy(Request $request, Member $member)
    {
        $member->delete();
        Storage::delete([
            $member->doc_file,
            $member->app_file,
            $member->consent_file,
            $member->discount_doc,
            $member->address_doc
        ]);

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.members.index');
    }

    public function command(Member $member)
    {
        $paid = 'reports/command_paid.docx';
        $free = 'reports/command_free.docx';
        $word = new TemplateProcessor($member->form_study == 1 ? $paid : $free);

        $word->setValues([
            'date_command' => @getDMY($member->created_at) . ' г.',
            'num'          => $member->id,
            'master'       => $member->master,
        ]);

        $table     = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontStyle = ['bold' => true];

        $table->addRow();
        $table->addCell(1000)->addText('№ <w:br/>п/п', $fontStyle);
        $table->addCell(3000)->addText('Ф.И.О. <w:br/>участника', $fontStyle);
        $table->addCell(3000)->addText('Дата рождения', $fontStyle);
        $table->addCell(3000)->addText('Категория <w:br/>группы', $fontStyle);
        $table->addCell(3000)->addText('Название <w:br/>группы', $fontStyle);
        $table->addCell(3000)->addText('Форма <w:br/>обучения', $fontStyle);

        $table->addRow();
        $table->addCell(1000)->addText(1);
        $table->addCell(3000)->addText(@getFIO('member', $member->id));
        $table->addCell(3000)->addText(@getDMY($member->birthday));
        $table->addCell(3000)->addText($member->group->category->name);
        $table->addCell(3000)->addText($member->group->title->name);
        $table->addCell(3000)->addText($member->form_study == 1 ? __('_field.paid') : __('_field.free'));

        $word->setComplexBlock('table', $table);

        $filename = __('_field.command') . ' №' . $member->id . ' от ' . @getDMY($member->created_at);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }
}
