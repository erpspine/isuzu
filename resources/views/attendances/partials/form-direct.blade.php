<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$item->staff_no}}</td>
    <td>
    @if($item->team_leader == 'yes')
        <span style="color:#da251c;">
            {{$item->staff_name}} (TeamLeader)</span>
    @else
        {{$item->staff_name}}

    @endif
    </td>
    <td>
        @if($item->team_leader == 'yes')
        <div class="input-group">
            <input type="text" name="direct_hrs[]" class="form-control normalhrs hrs" autocomplete="off" placeholder="Direct"
            id="direct_{{$num}}" required>

            <input type="text" name="indirect_hrs[]" class="form-control normalhrs hrs" autocomplete="off" placeholder="Indirect"
            id="indirect_{{$num}}" value="{{$indirect;}}" required>
        </div>
        @else
        <div class="input-group">
            <input type="text" id="direct_{{$num}}" name="direct_hrs[]" value="{{$direct;}}"
            class="form-control normalhrs hrs" autocomplete="off" placeholder="Direct" required>

            <input type="text" name="indirect_hrs[]" class="form-control normalhrs hrs" autocomplete="off" placeholder="Indirect"
                id="indirect_{{$num}}" required>
        </div>
        @endif
    
    </td>
    <td>
      
            @if($item->team_leader == 'yes')
            <div class="input-group">
                <input type="text" id="overtime_{{$num}}" name="overtime[]"
            class="form-control hrs" autocomplete="off" placeholder="Direct" required>

            <input type="text" id="indovertime_{{$num}}" name="indovertime[]"
            class="form-control hrs" autocomplete="off" placeholder="Indirect" required>
            </div>
            @else
            <div class="input-group">
            <input type="text" id="overtime_{{$num}}" name="overtime[]"
            class="form-control hrs" autocomplete="off" placeholder="Direct" required>

            <input type="text" id="indovertime_{{$num}}" name="indovertime[]"
            class="form-control hrs" autocomplete="off" placeholder="Indirect" required>
            </div>
            @endif
        
    </td>
    <td>
        <input type="text" name="authhrs[]" value="{{$overtime}}"
        class="form-control" autocomplete="off" placeholder="Hours" required>
    </td>

    <td>
        <input type="hidden" name="workdescription[]" value="0">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <select class="select2 interloanover" id="overshopto_{{$num}}" name="overshopto[]"
                style="width: 100%;">
                    @if ($item->shop_loaned_to > 0)
                        <option value="{{$item->shop_loaned_to}}">
                            {{ \App\Models\shop\Shop::where('id','=',$item->otshop_loaned_to)->value('report_name'); }}
                        </option>
                    @else
                        <option value="0">Choose shop...</option>
                    @endif

                    @foreach ($shops as $item1)
                        <option value="{{$item1->id}}">{{$item1->report_name}}</option>
                    @endforeach
                </select>
              </div>
                  <input type="text" readonly autocomplete="off"  id="loanov_{{$num}}" name="loanov[]" class="form-control hrs" placeholder="Hours...">
              </div>
          </div>

    </td>

    <td>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <select class="form-control select2 interloandir" id="dirshopto_{{$num}}" name="dirshopto[]"
                style="width: 100%;">
                    @if ($item->shop_loaned_to > 0)
                        <option value="{{$item->shop_loaned_to}}">
                            {{ \App\Models\shop\Shop::where('id','=',$item->shop_loaned_to)->value('report_name'); }}
                        </option>
                    @else
                        <option value="0">Choose shop...</option>
                    @endif

                    @foreach ($shops as $item1)
                        <option value="{{$item1->id}}">{{$item1->report_name}}</option>
                    @endforeach
                </select>
              </div>
                  <input type="text" readonly autocomplete="off" name="loandir[]" id="loandir_{{$num}}" class="form-control hrs" placeholder="Hours...">
              </div>
          </div>
    </td>
 

    <td><span  id="total{{$num}}">{{$item->direct_hrs + $item->indirect_hrs + $item->loaned_hrs}}</span> Hrs</td>

</tr>

