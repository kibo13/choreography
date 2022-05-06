export const calc = {
    age(date) {
        let today     = new Date();
        let birthday  = new Date(date);
        let age       = today.getFullYear() - birthday.getFullYear();
        let month     = today.getMonth() - birthday.getMonth();
        let condition = month < 0 || month === 0 && today.getDate() < birthday.getDate()

        return condition ? age-- : age;
    }
}
