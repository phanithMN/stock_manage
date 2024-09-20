// filter status 
document.getElementById('status_name').addEventListener('change', function() {
    let value = this.value;
    let url = new URL(window.location.href);
    url.searchParams.set('status_name', value);
    window.location.href = url.toString();
});

// // filter category 
// document.getElementById('category').addEventListener('change', function() {
//     let value = this.value;
//     let url = new URL(window.location.href);
//     url.searchParams.set('category', value);
//     window.location.href = url.toString();
// });

// arrow length 
document.getElementById('add_row_length').addEventListener('change', function() {
    let value = this.value;
    let url = new URL(window.location.href);
    url.searchParams.set('row_length', value);
    window.location.href = url.toString();
});

// select2
$(document).ready(function() {
    $('#product_id').select2();
})


