 <!-- Event List-->

 <body class="d-flex flex-column h-100 bg-light">
    <main class="flex-shrink-0">
        <section class="py-5">
            <div class="container px-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bolder mb-0"><span class="d-inline">Events</span></h1>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div id = "project-list" class="col-lg-11 col-xl-9 col-xxl-8">
                    
                    </div>
                </div>
            </div>
        </section>
    </main>
 </body>

 <script>
    GetEventList();
    async function GetEventList() {
        let URL = "/list-event";
        try {
            let response = await axios.get(URL);
            console.log(response.data);
            let eventData = response.data; // No need to parse here
            eventData.forEach((item) => {
                document.getElementById('project-list').innerHTML += `<div class="card overflow-hidden shadow rounded-4 border-0 mb-5">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center">
                            <div class="p-5">
                                <h2 class="fw-bolder">${item.title}</h2>
                                <p>${item.description}</p>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        } catch (error) {
            console.error("Error fetching event data:", error);
        }
    }
</script>


