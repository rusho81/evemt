<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Event Title</label>
                                <input type="text" class="form-control" id="eventTitle">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" id="eventDes">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" id="eventDate">
                                <label class="form-label">Time</label>
                                <input type="time" class="form-control" id="eventTime">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" id="eventLocation">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>

<script>
    async function Save() {
        let eventTitle = document.getElementById('eventTitle').value;
        let eventDes = document.getElementById('eventDes').value;
        let eventDate = document.getElementById('eventDate').value;
        let eventTime = document.getElementById('eventTime').value;
        let eventLocation = document.getElementById('eventLocation').value;

        if(eventTitle.length === 0){
            errorToast("Title Required!");
        }else if(eventDes.length === 0){
            errorToast("Event Deseription Required!");
        }else if(eventDate.length === 0){
            errorToast("Date Required!");
        }else if(eventTime.length === 0){
            errorToast("Time Required!");
        }else if(eventLocation.length === 0){
            errorToast("Location Required!");
        }
        else {
            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post('/create-event', {
                title:eventTitle,
                description:eventDes,
                date:eventDate,
                time:eventTime,
                location:eventLocation
            });
            hideLoader();

            if(res.status===201) {
                successToast('Request completed!');
                document.getElementById('save-form').reset();
                await getList();
            }else {
                errorToast("Request fail");
            }
        }
    }
</script>
