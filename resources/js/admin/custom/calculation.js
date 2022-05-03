export const calc = {
    age(date) {
        let today       = new Date();
        let birthday    = new Date(date);
        let age         = today.getFullYear() - birthday.getFullYear();
        let m           = today.getMonth() - birthday.getMonth();
        let condition   = m === 0 && today.getDate() < birthday.getDate()

        if (m < 0 || condition) age--;
        return age;
    }
}
