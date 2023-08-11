<div class="container" style="max-width: 100% !important;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Promotional Mail</h4>
                    <p>Send mail all customers</p>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-12 p-2">
                                <label>subject</label>
                                <input id="offerSub" placeholder="Subject" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-12 p-2">
                                <label>Last Name</label>
                                <textarea id="offerBody" cols="30" rows="20" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2" style="margin-left: auto;">
                                <button onclick="emailCampaign()" class="btn mt-3 w-100  btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const emailCampaign = async ()=> {
        let offerSub = document.getElementById('offerSub').value;
        let offerBody = document.getElementById('offerBody').value;
        if (offerSub.length === 0) {
            errorToast("Subject Required !");
        } else if (offerBody.length === 0) {
            errorToast("Body Required !");
        } else {
            showLoader();
            let res = await axios.post('/email-campaign', {
                offerSub: offerSub,
                offerBody: offerBody,
            });
            hideLoader()

            if(!res.data.status) {
                Object.keys(res.data.errors).forEach(function(field) {
                    let errorMessages = res.data.errors[field];
                    errorMessages.forEach(function(errorMessage) {
                        errorToast(`${errorMessage} `);
                    });
                });
            }

            if(res.data.status == 'failed') {
                errorToast(res.data.message);
            }

            if(res.data.status == 'success') {
                successToast(res.data.message);
            }
        }
    }
</script>
