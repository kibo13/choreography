export const compare = {
    dates(from, till, event) {
        let start = new Date(from)
        let end   = new Date(till)

        if (start.getTime() >= end.getTime()){
            event.preventDefault()
            alert('Дата окончания не должна предшествовать дате начала')
        }
    }
}
