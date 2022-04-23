const table = document.getElementById('is-datatable')

if (table) {
    $('.table').dataTable({
        language: {
            searchPlaceholder: 'Поиск',
            sProcessing: 'Подождите...',
            sLengthMenu: 'Показать _MENU_ записей',
            sZeroRecords: 'Записи отсутствуют.',
            sInfo: 'Записи с _START_ до _END_ из _TOTAL_ записей',
            sInfoEmpty: 'Записи с 0 до 0 из 0 записей',
            sInfoFiltered: '(отфильтровано из _MAX_ записей)',
            sInfoPostFix: '',
            sSearch: 'Поиск:',
            sUrl: '',
            oPaginate: {
                sFirst: 'Первая',
                sPrevious: '‹',
                sNext: '›',
                sLast: 'Последняя',
            },
            oAria: {
                sSortAscending:
                    ': активировать для сортировки столбца по возрастанию',
                sSortDescending: ': активировать для сортировки столбцов по убыванию',
            },
        },
        ordering: true,
        columnDefs: [
            {
                orderable: false,
                targets: 'no-sort',
            },
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [
                'Показывать по 10',
                'Показывать по 25',
                'Показывать по 50',
                'Все записи',
            ],
        ],
    })
}
