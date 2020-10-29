<thead class="thead-dark">
<tr>
<th scope="col"> بالعربي</th>
<th scope="col">بالإنجليزية </th>
<th scope="col">وقت الإنشاء</th>
<th scope="col"></th>
</tr>
</thead>
<tbody>
@foreach($records as $record)
  <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
    <td>{{Str::words($record->content_ar,6,'..')}}</td>
    <td>{{Str::words($record->content_en,6,'..')}}</td>
    <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
    <td>
      <button class="btn-sm btn btn-danger delete"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
      <button class="btn-sm btn btn-success edit" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
      <button class="btn-sm btn btn-primary get-record" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
    </td>
  </tr>
@endforeach
</tbody>
