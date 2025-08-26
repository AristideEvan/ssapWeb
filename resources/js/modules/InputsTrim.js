export function InputsTrim() {
    document.querySelectorAll('input[type="text"], textarea').forEach(input => {
        input.addEventListener('blur', function () { // Use a regular function
            this.value = this.value.trim(); // 'this' refers to the input element
        });
    });
}
