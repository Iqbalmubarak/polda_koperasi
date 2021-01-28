<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengeluaran Barang Terkait Covid 19</title>
    <style type="text/css" media="print">
      @page { size: landscape; }
    </style>
    <style>
    /* Generally, you should put CSS in a separate file, but for the purpose of this post, I'm including it in the style tag. */
    ins { background-color: #A0FFA0; }
    del { background-color: #FFA0A0; }
    .code { background-color: #EEEEEE; }
    .codex { background-color: #FFFFE0; }

    .custom-table {
      text-align: center;
      font-family: monospace;
      border-collapse: collapse;
      border-spacing: 0;
    }

    th {
      -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
        width: 130px;
    }

    /* Can't eliminate the spacing no matter what I try */
    th:first-child {
      height: 10px;
      width: 10px;
    }
    th:not(:first-child) {
      height: 130px;
      /* width: 5px; */
    }
    td:nth-child(2), td:nth-child(3), td:nth-child(4) {
      width: 10px;
    }
  </style>
</head>
<body>
  <div>
      <center><P>Daftar Pengeluaran Barang Terkait Covid 19<br>
        Tanggal : {{date_format(date_create($_GET['tanggal_mulai']),"d F Y")}} s/d {{date_format(date_create($_GET['tanggal_akhir']),"d F Y")}}</p> </center>
  </div>
  @php
    function mylabel($label){
      return ucfirst(str_replace("_"," ",$label));
    }
    $no = 1;
    $batas = 3;
    if($_GET['jenis_laporan']==2){
      $batas = 2;
    }
  @endphp
  <table border="2px solid" width="100%" cellpadding="2" class="custom-table">
  	<thead>
      <tr>
        <th style="transform: rotate(0deg);">No</th>
  			@foreach($label as $key => $value)
          @if($batas<$key)
            @if($value=="keluar" || $value=="sisa")
              <th style="transform: rotate(0deg);">{{mylabel($value)}}</th>
            @else
              <th>{{mylabel($value)}}</th>
            @endif
          @else
            <th style="transform: rotate(0deg);">{{mylabel($value)}}</th>
          @endif
        @endforeach
      </tr>
      <!-- <tr>
        <td>No</td>
        @foreach($label as $key => $value)
  			<td>{{mylabel($value)}}</td>
        @endforeach
      </tr> -->

      @foreach($data as $singelData)
        <tr>
          <td>{{$no++}}</td>
          @foreach($label as $keylabel => $singelLabel)
            @if($keylabel>$batas-1)
              <td>{{$singelData->$singelLabel}}</td>
            @else
              <td style="text-align:left">{{$singelData->$singelLabel}}</td>
            @endif
          @endforeach
        </tr>
      @endforeach
  	</thead>
  	<tbody>

    </tbody>
   </table>
  <script type="text/javascript">
    window.print();
  </script>
</body>
</html>
