<div class="row">
    <div class="col-md-6" >
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">إضافة طلب جديد</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label class="display-block">نوع الطلب</label>

                    <label class="radio-inline">
                        <input type="radio" class="styled" id="salon1"  name="type">
                        صالة
                    </label>

                    <label class="radio-inline">
                        <input type="radio" class="styled" id="delvary1" name="type">
                        ديلفيري
                    </label>
                </div>
                <div class="" id="salon">
                    <div class="form-group">
                            <label> رقم الطاولة</label>
                            <select class="select" name="table">
                                    <option value="AK">Alaska</option>
                            </select>
                    </div>
                </div>

                <div id="dilevary">
                        <div class="form-group">
                                <label>إسم المستخدم</label>
                                <input type="text" class="form-control" placeholder="إسم المستخدم">
                            </div>

                            <div class="form-group">
                                <label>رقم الهاتف</label>
                                <input type="text" class="form-control" placeholder="رقم الهاتف">
                            </div>

                            <div class="form-group">
                                <label>العنوان  بالتفصيل</label>
                                <textarea rows="5" cols="5" class="form-control" placeholder="العنوان بالتفصيل"></textarea>
                            </div>

                            <div class="form-group">
                                <label> محتوايات الطلب </label>
                            </div>

                </div>
                <div class="form-group">
                    <label>الإجمالي</label>
                    <input type="text" class="form-control" placeholder="الإجمالي">
                </div>

                <div class="form-group">
                    <label>الخصم</label>
                    <input type="text" class="form-control" placeholder="الخصم">
                </div>

                {{-- <div class="form-group">
                    <label>Your state:</label>
                    <select class="select">
                        <optgroup label="Alaskan/Hawaiian Time Zone">
                            <option value="AK">Alaska</option>
                            <option value="HI">Hawaii</option>
                        </optgroup>
                        <optgroup label="Pacific Time Zone">
                            <option value="CA">California</option>
                            <option value="NV">Nevada</option>
                            <option value="WA">Washington</option>
                        </optgroup>
                        <optgroup label="Mountain Time Zone">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="WY">Wyoming</option>
                        </optgroup>
                        <optgroup label="Central Time Zone">
                            <option value="AL">Alabama</option>
                            <option value="AR">Arkansas</option>
                            <option value="KY">Kentucky</option>
                        </optgroup>
                        <optgroup label="Eastern Time Zone">
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                        </optgroup>
                    </select>
                </div> --}}

                <div class="form-group">
                    <label class="display-block">الحالة</label>

                    <label class="radio-inline">
                        <input type="radio" class="styled" name="status" >
                        قيد الإنتظار
                    </label>

                    <label class="radio-inline">
                        <input type="radio" class="styled" name="status" >
                        يتم التجهيز
                    </label>

                    <label class="radio-inline">
                        <input type="radio" class="styled" name="status" >
                    جاهز
                    </label>

                    <label class="radio-inline">
                        <input type="radio" class="styled" name="status" >
                        تم الإلغاء
                    </label>
                </div>

                {{-- <div class="form-group">
                    <label class="display-block">Your avatar:</label>
                    <input type="file" class="file-styled">
                    <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                </div> --}}
                {{--<div class="form-group">
                    <label>Tags:</label>
                    <select multiple="multiple" data-placeholder="Enter tags" class="select-icons">
                        <optgroup label="Services">
                            <option value="wordpress2" data-icon="wordpress2">Wordpress</option>
                            <option value="tumblr2" data-icon="tumblr2">Tumblr</option>
                            <option value="stumbleupon" data-icon="stumbleupon">Stumble upon</option>
                            <option value="pinterest2" data-icon="pinterest2">Pinterest</option>
                            <option value="lastfm2" data-icon="lastfm2">Lastfm</option>
                        </optgroup>
                        <optgroup label="File types">
                            <option value="pdf" data-icon="file-pdf">PDF</option>
                            <option value="word" data-icon="file-word">Word</option>
                            <option value="excel" data-icon="file-excel">Excel</option>
                            <option value="openoffice" data-icon="file-openoffice">Open office</option>
                        </optgroup>
                        <optgroup label="Browsers">
                            <option value="chrome" data-icon="chrome" selected="selected">Chrome</option>
                            <option value="firefox" data-icon="firefox" selected="selected">Firefox</option>
                            <option value="safari" data-icon="safari">Safari</option>
                            <option value="opera" data-icon="opera">Opera</option>
                            <option value="IE" data-icon="IE">IE</option>
                        </optgroup>
                    </select>
                </div> --}}

                <div class="form-group">
                    <label>الملاحظات</label>
                    <textarea rows="5" cols="5" class="form-control" placeholder="ملاحظات الطلب"></textarea>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">حفظ  <i class="icon-arrow-left13 position-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-flat" id="salon">
            <div class="panel-heading">
                <h5 class="panel-title"> بيانات الطلب</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label> القسم</label>
                    <select class="select" name="table">
                            <option value="AK">Alaska</option>
                    </select>
                </div>


                <div class="form-group">
                        <label> العنصر</label>
                        <select class="select" name="item[]">
                            <option value="AK">Alaska</option>
                        </select>
                    </div>

                <div class="form-group">
                        <label> الحجم</label>
                        <select class="select" name="item[]">
                            <option value="AK">Alaska</option>
                        </select>
                </div>
                <div class="form-group">
                        <label>الكمية</label>
                        <input type="text" class="form-control" placeholder="الكمية">
                </div>

                <div class="text-right" id="add-more">
                        <button type="button" class="btn btn-primary">إضافة  <i class="icon-arrow-left13 position-right"></i></button>
                </div>
            </div>


    </div>

</div>
<div class="clear-fix"></div>
<div class="row">
   <div class="col-md-12">
    <div class="panel">
        <div class="field" id="field">
            <div class="field0" id="field0">

            </div>

        </div>

            <table class="table datatable-basic">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>إسم الطلب</th>
                            <th>الحجم</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th class="text-center">عمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="#">سي فود</a></td>
                            <td>وسط</td>
                            <td>20</td>
                            <td><span class="label label-success">1</span></td>
                            <td class="text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="#"><i class="icon-file-pdf"></i> حذف</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>

                    </tbody>
            </table>

    </div>
   </div>
</div>
