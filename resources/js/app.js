import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('change', (e) => {
    const input = e.target;
    if (!input.matches('form[data-toggle-task] input[type="checkbox"]')) return;
    const form = input.closest('form');
    form.requestSubmit();
});

document.addEventListener('submit', async (e) => {
    const form = e.target;
    if (!form.matches('form[data-toggle-task]')) return;
    e.preventDefault();

    const checkbox = form.querySelector('input[type="checkbox"]');
    const url = form.action;
    const title = form.closest('li')?.querySelector('span');
    try {
        await window.axios.patch(url);
        if (title) {
            title.classList.toggle('line-through', checkbox.checked);
            title.classList.toggle('text-gray-500', checkbox.checked);
        }
    } catch {
        checkbox.checked = !checkbox.checked;
        alert('An error occurred while updating the task status.');
    } finally {
        checkbox.disabled = false;
    }
});