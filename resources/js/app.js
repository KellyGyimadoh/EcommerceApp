import './bootstrap';
import '../css/app.css';
import.meta.glob(['../images/**'])

document.addEventListener('DOMContentLoaded', function () {

    const alertbox = document.querySelector(".alertbox");
    const alertmsg = document.querySelector(".alertmessage");
    const editCategoryButtons = document.querySelectorAll('[data-bs-target="#edit"]');
    const deleteCategoryButtons = document.querySelectorAll('[data-bs-target="#delete"]');
    const editProductButtons = document.querySelectorAll('[data-bs-target="#editproduct"]');
    const deleteProductButtons = document.querySelectorAll('[data-bs-target="#deleteproduct"]');
    const editcartitemButtons = document.querySelectorAll('[data-bs-target="#editcartitem"]');
    const deletecartitemButtons = document.querySelectorAll('[data-bs-target="#deletecartitem"]');
    const editOrderButtons = document.querySelectorAll('[data-bs-target="#editorder"]');
    const deleteOrderButtons = document.querySelectorAll('[data-bs-target="#deleteorder"]');
    const editcartproductform = document.getElementById("editcartproductform");
    const printReceiptButton= document.getElementById("printreceipt");

    // if (printReceiptButton) {
    //     printReceiptButton.addEventListener("click", function() {
    //        // window.open('/payments-receipt/print', ['id' => $order->id]) }}', '_blank');
    //     });
    // }

setTimeout(() => {
    if(alertbox)
{
    alertbox.style.display="none";
}
}, 3000);

    if (editcartproductform) {

        editcartproductform.preventDefault();
    }




    function setupFormActions(buttons, formSelector, actionUrl, actionType, fieldMappings = {}) {
        buttons.forEach((button) => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const id = button.getAttribute('data-id');
                try {
                    const response = await fetch(`${actionUrl}/${id}`);
                    if (!response.ok) {
                        throw new Error("Error fetching data");
                    }
                    const data = await response.json();

                    if (data.success) {
                        const form = document.querySelector(formSelector);
                        form.action = `${actionUrl}/${id}`;

                        if (actionType === 'edit') {
                            for (const [fieldName, dataKey] of Object.entries(fieldMappings)) {
                                const field = form.querySelector(`[name="${fieldName}"]`);

                                if (field) {
                                    field.value = data.data[dataKey] || '';
                                }
                            }
                        }
                    } else {
                        alertbox.style.display = "block";
                        alertmsg.innerText = "No records found";
                    }
                } catch (error) {
                    console.error(error);
                }
            });
        });
    }
    const editCategoryFieldMappings = {
        'name': 'name',
        'description': 'description',

        // Add more fields as needed
    };
    const editProductMappings = {
        'name': 'name',
        'description': 'description',
        'expiry_date': 'expiry_date',
        'status': 'status',
        'stock_quantity': 'stock_quantity',
        'price': 'price',
        'category_id': 'category_id'
    }

    const editcartitemMappings = {
        'product_id': 'product_id',
        'productname': 'productname',
        'price': 'price',
        'quantity': 'quantity',
    }
const editOrderMappings={
    'shipping_address':'shipping_address'
}
    // Set up edit and delete forms
    setupFormActions(editCategoryButtons, '#editform', '/categories', 'edit', editCategoryFieldMappings);
    setupFormActions(deleteCategoryButtons, '#deleteform', '/categories', 'delete');

    //for products
    setupFormActions(editProductButtons, '#editproductform', '/products', 'edit', editProductMappings);
    setupFormActions(deleteProductButtons, '#deleteproductform', '/products', 'delete');

    //for caritems
    setupFormActions(editcartitemButtons, '#editcartitemform', '/cartitems/item', 'edit', editcartitemMappings);
    setupFormActions(deletecartitemButtons, '#deletecartitemform', '/cartitems/item', 'delete');

//for orders
setupFormActions(editOrderButtons, '#editorderform', '/orders', 'edit', editOrderMappings);
setupFormActions(deleteOrderButtons, '#deleteorderform', '/orders', 'delete');

    const submitEditButton = document.querySelector("#submit-form");
    if(submitEditButton){
    submitEditButton.addEventListener('click', () => {
        const editForm = document.querySelector("#editform");
        const deleteForm = document.querySelector("#deleteform");
        const editproductForm = document.querySelector("#editproductform");
        const deleteproductForm = document.querySelector("#deleteproductform");
        const editcartitemform = document.querySelector("#editcartitemform");
        const deletecartitemform = document.querySelector("#deletecartitemform");
        const editorderform = document.querySelector("#editorderform");
        const deleteorderform = document.querySelector("#deleteorderform");


        if (editForm) {
            editForm.submit();
        } else if (deleteForm) {
            deleteForm.submit();
        } else if (editproductForm) {
            editproductForm.submit();
        } else if (deleteproductForm) {
            deleteproductForm.submit();
        } else if (editcartitemform) {
            editcartitemform.submit();
        }
        else if (deletecartitemform) {
            deletecartitemform.submit();
        }
        else if (editorderform) {
            editorderform.submit();
        }
        else if (deleteorderform) {
            deleteorderform.submit();
        }
    });
}


})
