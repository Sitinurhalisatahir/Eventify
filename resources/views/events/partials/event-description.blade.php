{{-- Event Description Partial --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-4">About This Event</h3>
    <div class="prose max-w-none text-gray-700">
        {!! nl2br(e($event->description)) !!}
    </div>
</div>