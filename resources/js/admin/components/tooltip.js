export const tag = {
    event(data) {
        return `
            <ul>
                <li>
                    <strong>Событие: </strong>
                    <span>${data.title}</span>
                </li>
                <li>
                    <strong>Место проведения: </strong>
                    <span>${data.place}</span>
                </li>
                <li>
                    <strong>Название концертного номера: </strong>
                    <span>${data.description}</span>
                </li>
            </ul>
        `
    },

    timetable(data) {
        return `
            <ul>
                <li>
                    <strong>Группа: </strong>
                    <span>${data.group}</span>
                </li>
                <li>
                    <strong>Категория: </strong>
                    <span>${data.category}</span>
                </li>
                <li>
                    <strong>Кабинет: </strong>
                    <span>${data.room}</span>
                </li>
                <li>
                    <strong>Время занятия: </strong>
                    <span>${data.title}</span>
                </li>
                <li>
                    <strong>Руководитель: </strong>
                    <span>${data.teacher}</span>
                </li>
            </ul>
        `
    }
}


