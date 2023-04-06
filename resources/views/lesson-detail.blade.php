@auth
<x-lesson-detail-auth 
 :lesson='$lesson' 
 :resevablePeople='$resevablePeople'
 :isReserved='$isReserved'
/>
@endauth

@guest
<x-lesson-detail-guest 
 :lesson='$lesson' 
 :resevablePeople='$resevablePeople'
 :isReserved='$isReserved'
/>
@endguest