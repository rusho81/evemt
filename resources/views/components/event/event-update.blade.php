<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Event</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Event Title</label>
                                <input type="text" class="form-control" id="eventUpdateTitle">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" id="eventUpdateDes">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" id="eventUpdateDate">
                                <label class="form-label">Time</label>
                                <input type="time" class="form-control" id="eventUpdateTime">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" id="eventUpdateLocation">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>

    async function FillUpUpdatedForm(id) {
        document.getElementById("updateID").value=id;
        showLoader();
        let res = await axios.post('/event-by-id', {id:id});
        hideLoader();
        document.getElementById("eventUpdateTitle").value=res.data['title'];
        document.getElementById("eventUpdateDes").value=res.data['description'];
        document.getElementById("eventUpdateDate").value=res.data['date'];
        document.getElementById("eventUpdateTime").value=res.data['time'];
        document.getElementById("eventUpdateLocation").value=res.data['location'];
    }
    async function Update() {
        var eventUpdateTitle = document.getElementById("eventUpdateTitle").value;
        var eventUpdateDes = document.getElementById("eventUpdateDes").value;
        var eventUpdateDate = document.getElementById("eventUpdateDate").value;
        var eventUpdateTime = document.getElementById("eventUpdateTime").value;
        var eventUpdateLocation = document.getElementById("eventUpdateLocation").value;
        var updateId = document.getElementById("updateID").value;

        if(eventUpdateTitle.length === 0){
            errorToast("Title Required!");
        }else if(eventUpdateDes.length === 0){
            errorToast("Description Required!");
        }else if(eventUpdateDate.length === 0){
            errorToast("Date Required!");
        }else if(eventUpdateTime.length === 0){
            errorToast("Preference Required!");
        }else if(eventUpdateLocation.length === 0){
            errorToast("Location Required!");
        }else {
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post('/update-event', {
                title:eventUpdateTitle,
                description:eventUpdateDes,
                date:eventUpdateDate,
                time:eventUpdateTime,
                location:eventUpdateLocation,
                id:updateId});
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast("Update Successfull");
                await getList();
            }else{
                errorToast("Update Failed");
            }
        }
    }
</script>