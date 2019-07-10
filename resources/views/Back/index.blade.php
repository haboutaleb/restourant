@extends('layouts.layout')

@section('title', 'الرئيسية')

@section('script')
	<!-- Theme JS files -->

    <script type="text/javascript" src="{{ url('/temp/assets') }}/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="{{ url('/temp/assets') }}/js/pages/user_pages_team.js"></script>


    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
	<!-- /theme JS files -->
@endsection

@section('content')

<!-- Dashboard content -->
<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-flat cards" style="">
            <div class="panel-heading">
                <h5 class="panel-title"> <u> الإحصائيات </u> </h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body" >
                <!-- Quick stats boxes -->
                <div class="row">

                    <div class="col-lg-4">
                        <a href="#">
                            <div class="panel bg-blue-400">
                                <div class="panel-body">
                                    <div class="heading-elements">
                                        <span class="heading-text badge bg-grey-800"> نشط </span>
                                    </div>
                                    <h3 class="no-margin">  {{  getModelCount('user') }}</h3>
                                    <h5>عدد االعملاء </h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a href="#">
                            <div class="panel bg-grey-400" style="background-color: #9b59b6;color: #fff;">
                                <div class="panel-body">
                                    <div class="heading-elements">
                                        <span class="heading-text badge bg-grey-800"> نشط </span>
                                    </div>
                                    <h3 class="no-margin">  {{  getModelCount('order') }}</h3>
                                    <h5> عدد الطلبات </h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a href="#">
                            <div class="panel bg-pink-400" style="background-color: #3498db;color: #fff;">
                                <div class="panel-body">
                                    <div class="heading-elements">
                                        <span class="heading-text badge bg-grey-800"> نشط </span>
                                    </div>
                                    <h3 class="no-margin">  {{  getModelCount('category') }}</h3>
                                    <h5> عدد الأقسام الرئسية </h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a href="#">
                            <div class="panel bg-blue-400" style="background-color: #e67e22;color: #fff;">
                                <div class="panel-body">
                                    <div class="heading-elements">
                                        <span class="heading-text badge bg-grey-800"> ملغي </span>
                                    </div>
                                    <h3 class="no-margin">
                                             {{  getModelCount('user', true) }} 
                                    </h3>
                                    <h5>  عدد العملاء  </h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a href="#">
                            <div class="panel bg-grey-400" style="background-color: #e74c3c;color: #fff;">
                                <div class="panel-body">
                                    <div class="heading-elements">
                                        <span class="heading-text badge bg-grey-800"> ملغي </span>
                                    </div>
                                    <h3 class="no-margin">  0 </h3>
                                    <h5>    عدد الطلبات  الخارجية</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a href="#">
                            <div class="panel bg-pink-400" style="background-color: #c0392b;color: #fff;">
                                <div class="panel-body">
                                    <div class="heading-elements">
                                        <span class="heading-text badge bg-grey-800"> نشط </span>
                                    </div>
                                    <h3 class="no-margin"> 0 </h3>
                                    <h5>   عدد الأقسام الفرعية </h5>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
                <!-- /quick stats boxes -->
            </div>
        </div>

    </div>

    <div class="col-lg-12">

        <!-- My messages -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title"> أخر الأنشطة </h6>
                <div class="heading-elements">
                    <span class="heading-text"><i class="icon-history text-warning position-left"></i> {{ date('M-d') }} , {{ date('H:i:s') }}</span>
                    <span class="label bg-success heading-text">نشط</span>
                </div>
            </div>


            <!-- Tabs -->
            <ul class="nav nav-lg nav-tabs nav-justified no-margin no-border-radius bg-indigo-400 border-top border-top-indigo-300">
                <li class="active">
                    <a href="#last_finished_orders" class="text-size-small text-uppercase" data-toggle="tab">
                        أخر الطلبات التي تم تسليمها
                    </a>
                </li>

                <li>
                    <a href="#last_delivery_registered" class="text-size-small text-uppercase" data-toggle="tab">
                        أخر الطلبات التي تم تسجيلها
                    </a>
                </li>

                <li>
                    <a href="#last_client_registered" class="text-size-small text-uppercase" data-toggle="tab">
                         أخر العملاء الذي تم إضافتهم
                    </a>
                </li>
            </ul>
            <!-- /tabs -->

            <!-- Tabs content -->
            <div class="tab-content">
                <div class="tab-pane active fade in has-padding" id="last_finished_orders">
                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <a href="" data-popup="lightbox">
                                    <img src="  " class="img-circle img-lg" alt="">
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="tab-pane fade has-padding" id="last_delivery_registered">
                    <ul class="media-list">
                
                        <li class="media">
                            <div class="media-left">
                                <a href="" data-popup="lightbox">
                                    <img src="" class="img-circle img-lg" alt="">
                                </a>
                            </div>

                            <div class="media-body">
                                <a href="" target="_blank">
                                   
                                    <span class="media-annotation pull-right"> </span>
                                </a>

                                <span class="display-block text-muted">  -  </span>
                            </div>
                        </li>
                    
                    </ul>
                </div>

                <div class="tab-pane fade has-padding" id="last_client_registered">
                    <ul class="media-list">
                    
                        <li class="media">
                            <div class="media-left">
                                <a href="" data-popup="lightbox">
                                    <img src="  " class="img-circle img-lg" alt="">
                                </a>
                            </div>

                            <div class="media-body">
                                <a href="#">
                                   
                                    <span class="media-annotation pull-right">  </span>
                                </a>

                                <span class="display-block text-muted">  </span>
                            </div>
                        </li>
                
                     
                    </ul>
                </div>
            </div>
            <!-- /tabs content -->

        </div>
        <!-- /my messages -->



    </div>
</div>
<!-- /dashboard content -->


@endsection
