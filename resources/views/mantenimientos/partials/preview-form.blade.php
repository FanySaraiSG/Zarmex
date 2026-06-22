<div class="fake-form">
    <h3>MANTENIMIENTO</h3>

    <div class="fake-field"></div>
    <div class="fake-field"></div>

    <div class="fake-row">
        <div class="fake-field"></div>
        <div class="fake-field"></div>
    </div>

    <div class="fake-field large"></div>

    <div class="fake-row">
        <div class="fake-field"></div>
        <div class="fake-field"></div>
    </div>

    <div class="fake-button">
        ENVIAR
    </div>
</div>

<style>
.fake-form{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    min-height:500px;
}

.fake-form h3{
    text-align:center;
    color:#234d50;
    font-weight:800;
    margin-bottom:25px;
}

.fake-field{
    height:45px;
    background:#edf2f7;
    border-radius:10px;
    margin-bottom:15px;
}

.fake-field.large{
    height:100px;
}

.fake-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.fake-button{
    margin-top:20px;
    background:#f8d37a;
    color:#234d50;
    text-align:center;
    font-weight:700;
    padding:12px;
    border-radius:10px;
}
</style>