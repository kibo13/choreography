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
                    <strong>Описание: </strong>
                    <span>${data.description}</span>
                </li>
            </ul>
        `
    }
}


