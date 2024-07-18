<div id="invCont">
    <div id="invCodeGen">
        <div id="Code">Код появится здесь</div>
        <input type="button" value="Сгенерировать код" onclick="generate()">
    </div>
    <div id="invCodeCont">
        <div id="invCodeArticle">
            Действующие коды приглашения:
        </div>
        @foreach(\App\InvitationKey::where('activated', false)->get() as $code)
            <div class="invCode">
                {{$code->code}}
            </div>
        @endforeach
    </div>
</div>
<script src="{{asset('js/keygen.js')}}">
</script>
