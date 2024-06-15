<div class="table-responsive">
    <table class="table" id="defectlist">
        <thead class="thead-light">
            <tr>
                <th>Qualy Zone</th>
                <th>Defect Condition </th>
                <th>Position </th>
                <th>0.5 </th>
                <th>1 </th>
                <th>10 </th>
                <th>50 </th>
           
                <th>Action</th>
            </tr>
        </thead>
        @if (count($records)>0)
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach ( $records as $record )
     <tr>
        <td><input name="item_id[{{ $i }}]" type="hidden" value="{{ $record->id }}"  id="item_id_{{ $i }}" /><textarea class="form-control" rows="2" placeholder="Quality Zone" name="defect_name[]" id="defect_name-{{ $i }}" >{{ $record->defect_name }}</textarea></td>
        <td><input type="text" class="form-control " placeholder="Defect Condition" name="defect_condition[]" value="{{ $record->defect_condition }}" id="defect_condition-{{ $i }}" ></td>
        <td > <input type="text" class="form-control " placeholder="Position" name="defect_position[]" value="{{ $record->defect_position }}"  id="defect_position-{{ $i }}" required></td>
        <td> <input name="factor_zero[{{ $i }}]" type="checkbox" value="0.5" id="md_checkbox_20" class="chk-col-red mt-2" id="factor_zero-{{ $i }}"  {{ ($record->factor_zero == 0.5) ? 'checked' : ''}} /></td>
        <td> <input name="factor_one[{{ $i }}]" type="checkbox" value="1"  id="md_checkbox_21" class="chk-col-red mt-2" id="factor_one-{{ $i }}"   {{ ($record->factor_one == 1) ? 'checked' : ''}} /></td>
        <td> <input name="factor_ten[{{ $i }}]" type="checkbox" value="10"  id="md_checkbox_25" class="chk-col-red mt-2" id="factor_ten-{{ $i }}"   {{ ($record->factor_ten == 10) ? 'checked' : ''}} /></td>
        <td> <input name="factor_fifty[{{ $i }}]" type="checkbox" value="50"  id="md_checkbox_26" class="chk-col-red mt-2" id="factor_fifty-{{ $i }}"  {{ ($record->factor_fifty == 50) ? 'checked' : ''}} /></td>
        <td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
        </tr>
        @php
        $i++;
    @endphp

            @endforeach
        </tbody>
     
            
        @endif
    </table>

</div>