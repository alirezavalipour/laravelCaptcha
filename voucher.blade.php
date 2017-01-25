@extends('layout.main')

@section('content')
    <div class="row">

        <div class="col-sm-6 col-sm-offset-3  col-xs-12 " style="direction: rtl" >
            <h3>دریافت اعتبار</h3>
            <form method="post" action="{{url('user/voucher/check')}}" >
                {{csrf_field()}}
                <div class="form-group">
                    <label>کد شارژ</label>
                    <input name="code" type="text" class="form-control" style="font-family: sans-serif" required>
                </div>
                <div class="form-group " >
                    <img src="{{url('captcha')}}" >
                    <input type="number" name="captcha" class="form-control" style="font-family: sans-serif" placeholder="عدد داخل تصویر" required>
                </div>

                <div >
                    <input class="btn red-background white-color " type="submit" value="بررسی شارژ">
                </div>
            </form>


        </div>
    </div>

@endsection


