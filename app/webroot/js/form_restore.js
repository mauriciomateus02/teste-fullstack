document.addEventListener('DOMContentLoaded', function () {

   
    const modalForm = document.getElementById('ServiceForm');

    if (modalForm) {
        modalForm.addEventListener('submit', function () {

         
            const form = document.getElementById('EmployeesForm');
            const data = {};

          
            new FormData(form).forEach((value, key) => {
                data[key] = value;
            });

          
            localStorage.setItem('employee_form_saved', JSON.stringify(data));
        });
    }

  
    const saved = localStorage.getItem('employee_form_saved');

    if (saved) {
        const data = JSON.parse(saved);

        Object.keys(data).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field && field.type !== 'file') {
                field.value = data[key];
            }
        });
        localStorage.removeItem('employee_form_saved');
    }
});
