@if ($marked == 'Not marked')

<tr>
    <input type="hidden" value="{{ $item->id }}" name="staff_id[]">
    <input type="hidden" name="marked_id[]" value="0" class="form-control"  id="markedid_{{ $num }}" >
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->staff_no }}</td>
    <td>
        {{ $item->staff_name }}
    </td>
    <td>
        <div class="input-group">
            <input type="text" id="direct_{{ $num }}" name="direct_hrs[]" value="{{ $direct }}"
                class="form-control normalhrs hrs" autocomplete="off" placeholder="Direct" required>
            <input type="text" name="indirect_hrs[]" class="form-control normalhrs hrs" autocomplete="off"
                placeholder="Indirect" id="indirect_{{ $num }}" required>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="text" id="overtime_{{ $num }}" name="othours[]" class="form-control hrs"
                autocomplete="off" placeholder="Direct" required>
            <input type="text" id="indovertime_{{ $num }}" name="indirect_othours[]" class="form-control hrs"
                autocomplete="off" placeholder="Indirect" required>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="text" name="auth_othrs[]"
                class="form-control" id="authhrs_{{$num}}" value="{{$overtime}}"
                placeholder="Hours"
                aria-describedby="basic-default-password" autocomplete="off" required />
            <span class="input-group-text cursor-pointer">
                <i class="mdi mdi-clipboard-text assetdetails"></i>
               </span>
        </div>
        <div class="assetdetails-con assetdetails-con_{{$num}} hide">
            <textarea class="form-control" name="workdescription[]" id="assetdescription-0" placeholder="Description"
                maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"  ></textarea>
        </div>

      
    </td>
    <td>
       
        <div class="col-lg-12 col-md-12 col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <select class="select2 interloanover" id="overshopto_{{ $num }}" name="otshop_loaned_to[]"
                        style="width: 100%;">
                        @if ($item->shop_loaned_to > 0)
                            <option value="{{ $item->shop_loaned_to }}">
                                {{  $item->shoploaned->report_name}}
                            </option>
                        @else
                            <option value="0">Select Shop</option>
                        @endif
                        @foreach ($shops as $item1)
                            <option value="{{ $item1->id }}">{{ $item1->report_name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" readonly autocomplete="off" id="loanov_{{ $num }}" name="otloaned_hrs[]"
                    class="form-control hrs" placeholder="Hrs">
            </div>
        </div>
    </td>
    <td>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <select class="form-control select2 interloandir" id="dirshopto_{{ $num }}"
                        name="shop_loaned_to[]" style="width: 100%;">
                        @if ($item->shop_loaned_to > 0)
                            <option value="{{ $item->shop_loaned_to }}">

                              {{  $item->shoploaned->report_name}}
                               
                            </option>
                        @else
                            <option value="0">Select Shop</option>
                        @endif

                        @foreach ($shops as $item1)
                            <option value="{{ $item1->id }}">{{ $item1->report_name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" readonly autocomplete="off" name="loaned_hrs[]" id="loandir_{{ $num }}"
                    class="form-control hrs" placeholder="Hrs">
            </div>
        </div>
    </td>
    <td><span id="total{{ $num }}">{{ $item->direct_hrs + $item->indirect_hrs + $item->loaned_hrs }}</span>
        Hrs</td>
        @if ($shop_type=='Yes')
        <td class="text-center">
            <div class="action-btn">
               
                <a href="javascript:void(0)" class="text-danger remove_inv_row ml-2"><i class="mdi mdi-delete font-20"></i></a>
            </div>
        </td>
        @endif
</tr>
@else
    <!--MARKED-->

    
    <tr>
        <input type="hidden" value="{{ $item->staff_id }}" name="staff_id[]">
        <input type="hidden" name="marked_id[]" value="{{ $item->id }}" class="form-control"  id="markedid_{{ $num }}" >
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->employee->staff_no }}</td>
        <td>{{ $item->employee->staff_name }}</td>
        <td>
            <div class="input-group">
                <input type="text" id="direct_{{ $num }}" name="direct_hrs[]" value="{{  (float)$item->direct_hrs }}"
                    class="form-control normalhrs hrs" autocomplete="off" placeholder="Direct" required>
                <input type="text" name="indirect_hrs[]" class="form-control normalhrs hrs" value="{{ (float)$item->indirect_hrs }}" autocomplete="off"
                    placeholder="Indirect" id="indirect_{{ $num }}" required>
            </div>
        </td>
        <td>
            <div class="input-group">
                <input type="text" id="overtime_{{ $num }}" name="othours[]"  value="{{ (float)$item->othours;}}" class="form-control hrs"
                    autocomplete="off" placeholder="Direct" required>
                <input type="text" id="indovertime_{{ $num }}" name="indirect_othours[]" class="form-control hrs"
                    autocomplete="off" placeholder="Indirect"  value="{{ (float)$item->indirect_othours;  }}"  required>
            </div>
        </td>
        <td>
            <div class="input-group">
                <input type="text" name="auth_othrs[]"
                    class="form-control" id="authhrs_{{$num}}"  value="{{ $item->auth_othrs }}"
                    placeholder="Hours"
                    aria-describedby="basic-default-password" autocomplete="off" required />
                <span class="input-group-text cursor-pointer">
                    <i class="mdi mdi-clipboard-text assetdetails"></i>
                   </span>
            </div>
            <div class="assetdetails-con assetdetails-con_{{$num}} {{ (empty($item->workdescription) || $item->workdescription==0   ) ? 'hide' : ''}}">
                <textarea class="form-control" name="workdescription[]" id="assetdescription-0" placeholder="Description"
                    maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"  >{{ $item->workdescription ? $item->workdescription : '' }}</textarea>
            </div>
    
          
        </td>
        <td>
           
            <div class="col-lg-12 col-md-12 col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <select class="select2 interloanover" id="overshopto_{{ $num }}"
                            name="otshop_loaned_to[]" style="width: 100%;">
                            <option value="0">Select shop</option>
                            @foreach ($shops as $item1)
                            <option value="{{ $item1->id }}" {{ ($item->otshop_loaned_to == $item1->id) ? 'selected' : ''}} >{{ $item1->report_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text"
                    {{ $item->otloaned_hrs > 0 ? '' : 'readonly' }}
                    autocomplete="off"
                    id="loanov_{{ $num }}"
                    name="otloaned_hrs[]" class="form-control hrs"
                    placeholder="Hours..."
                    value="{{  (float)$item->otloaned_hrs }}">
                </div>
            </div>
        </td>
        <td>
            <div class="col-lg-12 col-md-12 col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <select class="form-control select2 interloandir" id="dirshopto_{{ $num }}"
                            name="shop_loaned_to[]" style="width: 100%;">
                            <option value="0">Select Shop</option>
                            @foreach ($shops as $item1)
                            
                                <option value="{{ $item1->id }}" {{ ($item->shop_loaned_to == $item1->id) ? 'selected' : ''}} >{{ $item1->report_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" autocomplete="off"
                    {{ $item->loaned_hrs > 0 ? '' : 'readonly' }}
                    id="loandir_{{ $num }}"
                    name="loaned_hrs[]" class="form-control hrs"
                    placeholder="Hours..."
                    value="{{ $item->loaned_hrs }}">
                </div>
            </div>
        </td>
 
        <td><span
            id="total{{ $num }}">{{ $item->direct_hrs + $item->indirect_hrs + $item->othours + $item->indirect_othours + $item->otloaned_hrs + $item->loaned_hrs }}</span>
        Hrs</td>
        @if ($shop_type=='Yes')
            <td class="text-center">
                <div class="action-btn">
                   
                    <a href="javascript:void(0)" class="text-danger remove_inv_row ml-2"><i class="mdi mdi-delete font-20"></i></a>
                </div>
            </td>
            @endif
    </tr>

    @endif
