document.addEventListener('DOMContentLoaded', () => {
    const selectElement = document.querySelector(".payment");
    const result = document.querySelector(".payment-result");
    selectElement.addEventListener("change", (event) => {
        const result = document.querySelector(".payment-result");
        result.textContent = `${event.target.value}`;
    });
});