@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row">
        <div class="col-md-12 titleDieuXe"> THÊM MỚI CN PCCC </div>
    </div>
    <div class="row">
        <div class="col-md-12 prePage">
        <a href="{{ route('showF') }}" onclick="back()" class="" id="back">
                <span class="glyphicon glyphicon-step-backward">
                    <span class="prePage">DANH SÁCH CN PCCC</span>
                </span>
            </a>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning col-md-11">
                <div class="box-body">
                    <form action="/fire-certificate/create" method="post" name="itemForm" id="acountForm">
                        <div class="row">
                            <div class="form-group col-md-6 "> 
                                <label for="email">Loại xe (*):</label><label style="color: red; font-size: 13px"><i id="error-loaixe"></i></label>
                                <select class="select2" style="width:100%" disabled name = "selLoaixe" id = "selLoaixe" data-placeholder="-- Chọn loại xe --">
                                </select>
                            </div> 
                            <div class="form-group col-md-6 "> 
                                <label for="email">Số xe (*):</label><label style="color: red; font-size: 13px"><i id="error-soxe"></i></label>
                                <select class="select2" style="width:100%" disabled name = "selSoxe" id = "selSoxe" data-placeholder="-- Chọn số xe --">
                                </select>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Số phiếu PCCC (*):</label><label style="color: red; font-size: 13px"><i id="error-sophieu"></i></label>
                            <input type="text" class="form-control" name="txtSoPhieu" id="txtSoPhieu" placeholder="Nhập số phiếu bảo hiểm..." value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Ngày đăng ký (*):</label><label style="color: red; font-size: 13px"><i id="error-date"></i></label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input class="form-control" placeholder="Từ ngày" name="date" id="date" value="" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Ngày hết hạn (*):</label><label style="color: red; font-size: 13px"><i id="error-date1"></i></label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input class="form-control" placeholder="Từ ngày" name="date1" id="date1" value="" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Ghi chú </label>
                            <textarea class="form-control" rows="5" placeholder="Nhập ghi chú nếu cần" name="txtGhichu" id="txtGhichu"></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12"> <label for="email"></label><button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md">Lưu</button> 
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<!-- /.content -->
<!-- ==================================================================  JAVASCRIPT ====================================================== -->
<script>
    // function add option to selectBox
  /*
    select: where add option (.class or id of selectbox)
    options : array[{'value':'Value of option' , 'text': 'text display'}]
    */
    function addOptionSelectBox(select, options, colValue, colText){
      $.each(options, function (i, item) {
      // var lol = ''+colValue;
      // console.log(item[lol]);
      $(select).append($('<option>', { 
        value: item[colValue],
        text :  item[colText]
      }));
    });
    }

  // function search a element in array
  /*
    value : value search
    arr : array search
    filterCol: column of array
    => return undefined if array is empty or can't find
    */
    function arrSearch(value, arr, filterCol){
    // console.log(arr.length);
    if(arr.length == 0)
      return undefined;
    else{
      if(arr.length == 1){
        return arr[0];
      }
      for(var cArr = 0 ; cArr < arr.length; cArr++)
      {
        if(arr[cArr][filterCol] == value)
          return arr[cArr];
      }
    }
    return undefined;
  }
  // function lọc mảng con
  // duyệt mảng cha lọc ra mảng con theo điều kiện
  //value = id loOẠI cần lấy ra 1
  // arr : mảng tất cả các xe
  // filterCol : trường trong mảng xe cần so sánh
  // 
  function arrFilter(value, arr, filterCol){
    //alert('xxx');
    var chilArrayFilter =[];
    if(arr.length == 0)
      return undefined;
    if(arr.length == 1){
      if(arr[0][filterCol] == value){
        chilArrayFilter.push(arr[0]);
      }else{
        return undefined;
      }
    }
    if(arr.length > 1){
      for(var cArrFilter = 0 ; cArrFilter < arr.length; cArrFilter++){
        if(arr[cArrFilter][filterCol] == value){
          chilArrayFilter.push(arr[cArrFilter]);
        }
      }
    }
    if(chilArrayFilter.length == 0)
      return undefined;
    else
      return chilArrayFilter;

  }

     //call ajax to get car data
     var resData;
  var operating ;


    $.ajax('{{url("maintenance/car_id")}}', {
      type: 'GET',  
      data: {id: {{$id}}},
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
          resData = result.success;
          $('#selSoxe').append($('<option>', {
                value: resData['cars']['0']['car_id'],
                text: resData['cars']['0']['car_num']
            }));
            
            $('#selLoaixe').append($('<option>', {
                value: resData['cars']['0']['car_type_id'],
                text: resData['cars']['0']['name']
            }));
            
       }else{
        swal("Lỗi", "Không tìm thấy !", "error");
      } 
    }

  });


   </script>

   <script>
    $(function () {
  //Initialize Select2 Elements
  $('.select2').select2(
  {
      // placeholder: "Assign to:",
      allowClear: true
    }
    )

})
</script>

<script>
   var start ='';
    var end = '';
   
    $('#date').focusin(function(){
        $('#btnOk').attr('disabled','disabled' );
    })
    $('#date1').focusin(function(){
        $('#btnOk').attr('disabled','disabled' );
    })
    $('#date').focusout(function(){
        $('#btnOk').removeAttr('disabled','disabled' );
        start= $('#date').val();
        end= $('#date1').val();
        var date1 = new Date(start);
        var date2 = new Date(end);

        if(date1 > date2 ){
            swal({
                title: "Error!",
                text: "Bạn cần kiểm tra lại ngày !",
                icon: "warning"
            });
            $('#btnOk').attr('disabled','disabled' );
        }else{
            $('#btnOk').removeAttr('disabled','disabled' );
        }

    })
    $('#date1').focusout(function(){
        $('#btnOk').removeAttr('disabled','disabled' );
        start= $('#date').val();
        end= $('#date1').val();
        var date1 = new Date(start);
        var date2 = new Date(end);


        if(date1 > date2 ){
            swal({
                title: "Error!",
                text: "Bạn cần kiểm tra lại ngày !",
                icon: "warning"
            });
            $('#btnOk').attr('disabled','disabled' );
        }else{
            $('#btnOk').removeAttr('disabled','disabled' );
        }
        
    
    })

  $(function () {
    $('#tblDriver').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
  })

  $(document).ready(function (){
        $('#btnOk').click(function(e){
            e.preventDefault(); // khong load lại nut submit

            data = new FormData();

            data.append('selLoaixe', $("#selLoaixe").val());
            data.append('selSoxe', $("#selSoxe").val());
            data.append('txtSoPhieu', $("#txtSoPhieu").val());
            data.append('date', $("#date").val());
            data.append('date1', $("#date1").val());
            data.append('txtGhichu', $("#txtGhichu").val());
           
            start= $('#date').val();
            end= $('#date1').val();
            var date1 = new Date(start);
            var date2 = new Date(end);
            
            if(date1 < date2 || start == '' || end == ''){
            $.ajax({
                data:data,
                url: "{{ url('/fire-certificate/create')}}",
                type: "POST",
                headers: {
                        //'X-CSRF-TOKEN': $("input[name='_token']").val()
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                processData: false,
                contentType: false,
                success: function(data){
                    console.log(data)
                    if(data.success){
                        if ('referrer' in document) {
                            let prePage = document.referrer;
                            //alert(prePage);
                            if (prePage.indexOf('?') > -1)
                             prePage = prePage.substring(0, prePage.indexOf('?'));
                           // alert(prePage);
                            let topPage = {{$id}};
                            let typePage = 'fireCertificate';
                            let preURL = prePage+'?type='+typePage;
                          // alert(preURL);
                            window.location = preURL;
                            /* OR */
                            //location.replace(document.referrer);
                        } else {
                            window.history.back();
                        }
                    }
                    if(data.errors){
                        if(data.errors.selLoaixe) {
                            $('#error-loaixe').text(' '+data.errors.selLoaixe)
                        }else $('#error-loaixe').text('')
                        if(data.errors.selSoxe) {
                            $('#error-soxe').text(' '+data.errors.selSoxe)
                        }else $('#error-soxe').text('')
                        if(data.errors.txtSoPhieu) {
                            $('#error-sophieu').text(' '+data.errors.txtSoPhieu)
                        }else $('#error-sophieu').text('')
                        if(data.errors.date) {
                            $('#error-date').text(' '+data.errors.date)
                        }else $('#error-date').text('') 
                        if(data.errors.date1) {
                            $('#error-date1').text(' '+data.errors.date1)
                        }else $('#error-date1').text('')
                    }
                }
            })
            }else  
                swal({
                    title: "Error!",
                    text: "Bạn cần kiểm tra lại ngày !",
                    icon: "warning"
                });
        })
    })
</script>
@endsection