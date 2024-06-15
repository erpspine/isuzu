<div class="table-responsive">
    <table class="table" id="defectlist">
        <thead class="thead-light">
            <tr>
                <th>Critical Operation</th>
                <th>Description</th>
                <th>Pos </th>
                <th>L </th>
                <th>D </th>
                <th>W </th>
                <th>M </th>
                <th>F</th>
                <th>10 </th>
                <th>20 </th>
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
            <td><input name="item_id[{{ $i }}]" type="hidden" value="{{ $record->id }}"  id="item_id_{{ $i }}" /> <textarea class="form-control" rows="2" placeholder="Operation" name="defect_name[]" id="defect_name-{{ $i }}" required>{{ $record->defect_name }}</textarea></td>
            <td> <textarea class="form-control" rows="2" placeholder="Description" name="defect_condition[]" id="defect_condition-{{ $i }}" >{{ $record->defect_condition }}</textarea></td>
            <td > <input type="text" class="form-control " placeholder="Position" name="defect_position[]" value="{{ $record->defect_position }}"  id="defect_position-{{ $i }}" required></td>
            <td> <input name="loose[{{ $i }}]" type="checkbox" value="L" id="md_checkbox_20" class="chk-col-red mt-2" {{ ($record->loose == 'L') ? 'checked' : ''}}  /></td>
            <td> <input name="dermaged[{{ $i }}]" type="checkbox" value="D"  id="md_checkbox_21" class="chk-col-red mt-2" {{ ($record->dermaged == 'D') ? 'checked' : ''}}  /></td>
            <td> <input name="wrong_assembly[{{ $i }}]" type="checkbox" value="W"  id="md_checkbox_22" class="chk-col-red mt-2" {{ ($record->wrong_assembly == 'W') ? 'checked' : ''}}  /></td>
            <td> <input name="lack_of_parts[{{ $i }}]" type="checkbox" value="M"  id="md_checkbox_23" class="chk-col-red mt-2" {{ ($record->lack_of_parts == 'M') ? 'checked' : ''}}  /></td>
            <td> <input name="function_defect[{{ $i }}]" type="checkbox" value="F"  id="md_checkbox_24" class="chk-col-red mt-2"  {{ ($record->function_defect == 'F') ? 'checked' : ''}} /></td>
            <td> <input name="factor_ten[{{ $i }}]" type="checkbox" value="10"  id="md_checkbox_25" class="chk-col-red mt-2"  {{ ($record->factor_ten == 10) ? 'checked' : ''}} /></td>
            <td> <input name="factor_one[{{ $i }}]" type="checkbox" value="20"  id="md_checkbox_26" class="chk-col-red mt-2" {{ ($record->factor_one == 20) ? 'checked' : ''}} /></td>
            <td> <input name="factor_fifty[{{ $i }}]" type="checkbox" value="50"  id="md_checkbox_26" class="chk-col-red mt-2" {{ ($record->factor_fifty == 50) ? 'checked' : ''}} /></td>
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