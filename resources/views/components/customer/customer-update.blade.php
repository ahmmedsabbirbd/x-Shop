<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success">Update</button>
            </div>
        </div>
    </div>
</div>


<script>
    async function fillUpUpdateForm(id) {
        document.getElementById('updateID').value = id;
        showLoader();
        let res = await axios.post('/customer-by-id', {
            id: id
        });
        document.getElementById('customerNameUpdate').value = res.data['name'];
        document.getElementById('customerEmailUpdate').value = res.data['email'];
        document.getElementById('customerMobileUpdate').value = res.data['mobile'];
        hideLoader();
    }

    async function Update() {
        let customerName = document.getElementById('customerNameUpdate').value;
        let customerEmail = document.getElementById('customerEmailUpdate').value;
        let customerMobile = document.getElementById('customerMobileUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if(customerName.length === 0) {
            errorToast("Customer Name Required !");
        }else if (customerEmail.length === 0) {
            errorToast("Customer Email Required !");
        }else if (customerMobile.length === 0) {
            errorToast("Customer Mobile Required !");
        }else {
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post('/customer-update', {
                name: customerName,
                email: customerEmail,
                mobile: customerMobile,
                id: updateID
            })
            hideLoader();
            if (res.data === 1 && res.status === 200) {
                successToast('Request Success !');
                await getList();
            } else {
                errorToast('Request Failed !');
            }
        }
    }
</script>
