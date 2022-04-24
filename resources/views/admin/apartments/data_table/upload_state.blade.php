
@if ($upload_state ==1)
    <span class="label text-success d-flex">
        <div class="dot-label bg-success ml-1"></div>Approved
     </span>
@elseif($upload_state ==3)
    <span class="label text-warning d-flex">
    <div class="dot-label bg-danger ml-1"></div>Waiting
 </span>

    @else
    <span class="label text-danger d-flex">
    <div class="dot-label bg-danger ml-1"></div>Unapproved
 </span>

@endif
