document.addEventListener('DOMContentLoaded', function() {
    var deleteModal = document.getElementById('deleteModal');
    
    deleteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; 
        var employeeId = button.getAttribute('data-employee-id');
        var employeeName = button.getAttribute('data-employee-name');
        
        var nameField = deleteModal.querySelector('#employeeName');
        nameField.textContent = employeeName;
        
        var idField = deleteModal.querySelector('#deleteEmployeeId');
        idField.value = employeeId;
    });
    
    deleteModal.addEventListener('hidden.bs.modal', function() {
        var nameField = deleteModal.querySelector('#employeeName');
        nameField.textContent = '';
        
        var idField = deleteModal.querySelector('#deleteEmployeeId');
        idField.value = '';
    });
});