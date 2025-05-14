@extends('user_page.layout')
@section('style')
<style>
    .info-card {
        background-color: #E6EEF7;
        border-radius: 10px;       
        height: 200px;
        padding: 20px;
        text-align: center;
        transition: transform 0.2s;
    }

</style>
@endsection

@section('content')
<div class="container mt-5 text-center">
    <div class="container">
            <div class="row">
            <div class="col-12 col-md-6 mb-4 d-flex justify-content-center">
                <div class="info-card" style="width: 90%; height: 400px;">
                <div>
                    <h5 class="mb-2">Self Improvement</h5>
                </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4 d-flex justify-content-center">
                <div class="info-card" style="width: 90%; height: 400px;">
                <div >
                    <h5 class="mb-2">Pray Activity</h5>
                    <p class="small mb-0">with all member</p>
                </div>

                </div>
            </div>
            <div class="col-12 mb-4 d-flex justify-content-center">
                <div class="info-card" style="width: 95%; height: 200px;">
                <div >
                    <h5 class="mb-2">Pray Activity</h5>
                    <p class="small mb-0">with all member</p>
                </div>

                </div>
            </div>
            </div>
        </div>
    </div>

</div>
@endsection