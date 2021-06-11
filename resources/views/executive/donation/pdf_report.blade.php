<!DOCTYPE html>
<html>
<head>
<style>
.fields {
            border: 1px solid grey;
            width: 23%;
            white-space:nowrap;
        }
        .fields1 {
            border: 1px solid grey;
            width: 18%;
            white-space:nowrap;
        }
        table, th, td {
            border: 1px solid black;
  border-collapse: collapse;
}
 
</style>
</head>

    <div class="row">
        <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h1 class="box-title" style="position:absolute; top:-8px;"><img src="https://donate.risingsun.org.pk/img/logo-rsi.png" style="width:150px;height:100px;" ></h1> 
                        <h6 style="position:absolute; top:-38px; left:150px; font-size:17px; font-family:Arial, Helvetica, sans-serif">RISING SUN EDUCATION & WELFARE SOCIETY (Regd)</h6>
                        <h6 style="position:absolute; top:-17px; left:180px;  font-size:16px; font-family:Arial, Helvetica, sans-serif">RISING SUN INSTITUTE FOR SPECIAL CHILDREN</h6>
                         
                        
                    </div>

                    <div class="date" style="position:absolute; top:130px;  left:500px;  font-size:12px">
                         <span class="input-group-addon">Date:</span>
                         <span>
                          <input type="text"  class="form-control" size="15" style="" value="{{ date('d-m-Y', strtotime($donation_record->enter_date)) }}" />
                         </span>
                    </div>
                    <div class="date" style="position:absolute; top:130px; font-size:12px">
                         <span class="input-group-addon">Receipt Track Number:</span>
                         <span>
                          <input type="text"  class="form-control" size="15" value="{{ $donation_record->receipt}}" />
                         </span>
                    </div>
                    <div class="name" style="position:absolute; top:163px;  font-size:12px">
                        <span class="input-group-addon">Received With Thanks from:</span>
                        <span>
                         
                          <input type="text"  class="form-control" size="65" value="{{ $donation_record->cust_name }}" />
                          
                        </span>
                    </div>
                    <div class="name" style="position:absolute; top:195px;  font-size:12px">
                        <span class="input-group-addon">Address:</span>
                        <span>
                         
                          <input type="text"  class="form-control" size="78" value="{{ $donation_record->address }}" />
                          
                        </span>
                    </div>
                    <div class="7th" style="position:absolute; top:230px;  font-size:12px">
                        
                        <span class="input-group-addon" >Tel#:</span>
                        <span><input type="text" class="form-control" size="12" value="{{ $donation_record->phone_no }}" placeholder="Hospital Name" readonly /></span>
                        <span class="input-group-addon">Donar Status:</span>
                        <span>
                        <input type="text" style="" class="form-control" size="28" value="{{ $donation_record->donar_status }}" placeholder="Designation" readonly /></span>
                        <span class="input-group-addon">Rupees:</span>
                        <span>
                        <input type="text"  class="form-control" size="16" style="" value="{{ $donation_record->rupees }}"  readonly />
                        </span>

                        
                    </div>

                    <div class="7th" style="position:absolute; top:260px;  font-size:12px">
                        
                        <span class="input-group-addon" >the Sum of Rupees:</span>
                        <span><input type="text" class="form-control" size="72" value="{{ $donation_record->sum_of_rupees }} {{ $donation_record->currency }}" placeholder="Hospital Name" readonly /></span>
                     
                    </div>
                    <div class="7th" style="position:absolute; top:290px;  font-size:12px">
                        
                        <span class="input-group-addon" >By Cash/Cheque Draft No:</span>
                        <span><input type="text" class="form-control" size="11" value="{{ $donation_record->draft_no }}" placeholder="Hospital Name" readonly /></span>
                        <span class="input-group-addon">Dated:</span>
                        <span>
                        @if($donation_record->draft_date == '') 
                        <input type="text" style="" class="form-control" size="12" value="" placeholder="Designation" readonly />
                        @else 
                        <input type="text" style="" class="form-control" size="12" value="{{ date('d-m-Y', strtotime($donation_record->draft_date)) }}" placeholder="Designation" readonly />
                        @endif
                        </span>
                        <span class="input-group-addon" >Drawn On:</span>
                        <span><input type="text" class="form-control" size="22" style="" value="{{ $donation_record->drawn_on }}" placeholder="Hospital Name" readonly /></span>
                        
                    </div>

                    <div class="7th" style="position:absolute; top:325px;  font-size:12px">
                        
                        
                        <span class="input-group-addon">Donation Type:</span>
                        <span>
                        <input type="text" style="" class="form-control" size="73" value="{{ $donation_record->donation_type }}" placeholder="Designation" readonly /></span>

                        
                    </div>

                    <div class="7th" style="position:absolute; top:360px;  font-size:12px">
                        
                        <span class="input-group-addon" >No of Children Sponsered:</span>
                        <span><input type="text" class="form-control" size="11" value="{{ $donation_record->no_of_children }}" placeholder="Hospital Name" readonly /></span>
                        <span class="input-group-addon">From:</span>
                        <span>
                        @if($donation_record->from_date == '') 
                        <input type="text"  class="form-control" style="" size="20" value="" placeholder="Designation" readonly />
                        @else 
                        <input type="text" class="form-control" style="" size="20" value="{{ date('d-m-Y', strtotime($donation_record->from_date)) }}" placeholder="Designation" readonly />
                        @endif
                        </span>
                        <span class="input-group-addon" >To:</span>
                        <span>
                        @if($donation_record->to_date == '') 
                        <input type="text"  class="form-control" style="" size="19" value="" placeholder="Designation" readonly />
                        @else 
                        <input type="text" class="form-control" style="" size="19" value="{{ date('d-m-Y', strtotime($donation_record->to_date)) }}" placeholder="Designation" readonly />
                        @endif
                        </span>
                        
                    </div>

                    <div class="7th" style="position:absolute; top:400px;  font-size:12px">
                        
                        <span class="input-group-addon" >Remarks:</span>
                        <span><input type="text" class="form-control" size="75" value="{{ $donation_record->remarks }}" placeholder="Hospital Name" readonly /></span>
                         
                        
                    </div>
                    <div class="7th" style="position:absolute; top:425px;  font-size:12px">
                        
                    <p style="position:absolute;  font-size:12px">DHA Campus: 544/2-XX, Phase III, Khayaban-e-Iqbal, D.H.A. Lahore. Ph: +92 42 111 774 444, +92-42-35899252, +92 333 1211038  </p>
                    <p style="position:absolute; top:18px; font-size:12px">Mughalpura Campus: 33-34-LARECHS III, Post Office Scheme, Mughalpura, Lahore. Tel: +92-42-36882251-52-53, Mob: +92 333 1211071</p>

                        
                    </div>

                    
                    
                        
                </div>
              <!-- /.box-body -->
              
        </div>
    </div>
        <!-- /.col -->
  




</body>
</html>