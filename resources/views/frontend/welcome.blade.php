@extends("layouts.front")
@section("front-end")


 {{-- welcome page # --}}

 <livewire:frontend.component.welcome />


  {{-- item summary  --}}
 <livewire:frontend.component.ilist />

  {{-- choose us  --}}

  <livewire:frontend.component.choose-us />

   {{-- Our Team  --}}
   <livewire:frontend.component.team />


   {{-- feature list  --}}

   <livewire:frontend.component.features />


   {{-- student testimonial  --}}
   <livewire:frontend.component.testimonial />


   {{-- Number summary / counter  --}}
   <livewire:frontend.component.number-summary />


   {{-- Hub list - scrollable  --}}
   <livewire:frontend.component.hub-list />


   {{-- blog list  --}}
   <livewire:frontend.component.blog />


   {{-- contact  us page # --}}

   <livewire:frontend.component.contact-us />


   {{-- general footer  --}}

  <livewire:frontend.component.general-footer />

@endsection
