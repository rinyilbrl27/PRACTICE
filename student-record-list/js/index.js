function toggleCheckboxes(selectAll) {
    const checkboxes = document.querySelectorAll('.subject-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}