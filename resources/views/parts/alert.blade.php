@if(isset($alertMessage) || isset($messages))
    <div class="avia_message_box avia-color-{{ (isset($alertClass) ? $alertClass : 'red') }} avia-size-normal avia-icon_select-no avia-border-">
    <div class="avia_message_box_content">
        @if (count($messages) > 0)
            <ul style="margin:0; @if(isset($alertTitle)) padding-left: 90px; @endif text-align: left;">
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endif