@extends("layouts.front")
@section("front-end")


<livewire:frontend.component.hub-welcome  :hubId="$hub->id"/>


<div class="bg-[#EB688C] text-white text-center py-4 px-6 shadow-xl  flex items-center justify-center animate-bounce">
    <p class="text-lg font-bold">
        🚨 Registration window is open!
        <a href="{{ route('application.window') }}" class="underline font-extrabold hover:text-yellow-300 transition-all">Click to apply</a>
    </p>
</div>





<livewire:frontend.component.hub-about   :hubId="$hub->id"/>


<livewire:frontend.component.hub-mission   :hubId="$hub->id"/>



<livewire:frontend.component.blog   :hubId="$hub->id" />



<section
  aria-label="Location and Availability"
  class="relative z-20 overflow-hidden bg-cover bg-center bg-blue-50 "
  style="background-: "
>
  <div class="container mx-auto px-4 py-10">
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 text-white bg-opacity-75 lg:flex lg:items-center lg:justify-between"
    >
      <!-- Location -->
      <div class="text-center">
        <p class="text-subtitle text-primary mb-2">LOCATION</p>
        <p class="text-body-sm mb-2"> University Of Dar es Salaam - Tanzania  </p>
        <p class="text-stats-xl"> {{ $hub->address }} </p>
      </div>

      <!-- Availability Status -->
      <div class="text-center">
        <p class="text-subtitle text-primary mb-2">AVAILABILITY</p>
        <p class="text-body-sm mb-2">Status</p>
        <p class="text-stats-xl text-green-500">Open</p>
      </div>

      <!-- Working Hours -->
      <div class="text-center">
        <p class="text-subtitle text-primary mb-2">WORKING HOURS</p>
        <p class="text-body-sm mb-2">Monday - Friday</p>
        <p class="text-stats-xl">8:00 AM - 6:00 PM</p>
      </div>


    </div>
  </div>
</section>



@endsection
