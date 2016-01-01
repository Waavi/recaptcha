<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey="{!! $siteKey !!}"@foreach($options as $name => $value){!! ' data-' . $name . '="' . $value . '"' !!}@endforeach></div>
