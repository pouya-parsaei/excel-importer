<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Import excel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
            integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2"
            crossorigin="anonymous"></script>
</head>
<script src="https://cdn.socket.io/4.4.1/socket.io.min.js"
        integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H"
        crossorigin="anonymous"></script>
<body>
<section style="padding-top:60px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Import
                    </div>
                    <div class="card-body" id="app">
                        <h2>@{{progress}}</h2>
                        <hr>
                        <h5>@{{pageTitle}}</h5>
                        <hr>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                 role="progressbar"
                                 :aria-valuenow="progressPercentage"
                                 aria-valuemin="0"
                                 aria-valuemax="100"
                                 :style="`width: ${progressPercentage}%;`">
                                @{{ progressPercentage }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- development version -->
<script src="https://unpkg.com/vue@next"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script type="text/javascript">
    const app = {
        data() {
            return {
                progress: 'Welcome to progress page',
                pageTitle: 'progress of downloads',
                progressPercentage: 0,
                params: {
                    id: null
                }
            }
        },
        methods: {
            checkIfIdPresent() {
                const urlSearchParams = new URLSearchParams(window.location.search);
                const params = Object.fromEntries(urlSearchParams.entries());

                if (params.id) {
                    this.params.id = params.id;
                }
            },
            getUploadProgress() {
                let self = this;
                self.checkIfIdPresent();
                // Get progress data.
                let progressResponse = setInterval(()=>{
                axios.get('/progress/data', {
                    params: {
                        id: self.params.id ? self.params.id :
                            "{{session()->get('lastBatchId')}}",
                    }
                }).then(function (response) {
                    // console.log(response.data);
                    let totalJobs = parseInt(response.data.total_jobs);
                    let pendingJobs = parseInt(response.data.pending_jobs);
                    let completedJobs = totalJobs - pendingJobs;
                    if (pendingJobs == 0) {
                        self.progressPercentage = 100;
                    } else {
                        self.progressPercentage = parseInt(completedJobs / totalJobs * 100).toFixed(0);
                    }

                    if (parseInt(self.progressPercentage) >= 100) {
                        clearInterval(progressResponse);
                    }

                })
                },1000);
            }
        },
        created() {
            this.getUploadProgress();
        }
    }
    Vue.createApp(app).mount("#app");
</script>

</body>
</html>
