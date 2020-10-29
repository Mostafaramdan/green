<thead class="thead-dark">
<tr>
<th scope="col"> </th>
<th scope="col"># </th>
</tr>
</thead>
<tbody>
    <tr >
        <td> التليفون</td>
        <td>{{$record->phone}}</td>
    </tr>
    <tr >
        <td>الايميل</td>
        <td>{{$record->email}}</td>
    </tr>
    <tr >
        <td> عن التطبيق بالعربي</td>
        <td>{{$record->aboutUs_ar}}</td>
    </tr>
    <tr >
        <td> عن التطبيق بالإنجليزية</td>
        <td>{{$record->aboutUs_en}}</td>
    </tr>
    <tr >
        <td>  سياسة الإستخدام بالعربي</td>
        <td>{{$record->policyTerms_ar}}</td>
    </tr>
    <tr >
        <td>  سياسة الإستخدام بالإنجليزية</td>
        <td>{{$record->policyTerms_en}}</td>
    </tr>
    <tr >
        <td>عدد ايام التوصيل </td>
        <td>{{$record->daysToDelivery}}</td>
    </tr>
</tbody>
