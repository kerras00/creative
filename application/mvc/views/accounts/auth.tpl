<div class="container">

    <div class="auth-box">
        <div class="auth-box-body">

            <div class="auth-logo">
                <h1>{Lang::get('auth.auth')}</h1>
            </div>

            <form id="form-auth" class="form-view" action="" method="post" enctype="multipart/form-data" data-success="" data-toastr-position="top-right">
                <fieldset>
                    <div class="form-group has-feedback">
                        <label for="email">{Lang::get('auth.email')}</label>
                        <input id="email" type="email" class="form-control" required placeholder="Email" value="brincon@megacreativo.com">
                        <span class="fa fa-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="pass">{Lang::get('auth.pass')}</label>
                        <input id="pass" type="password" class="form-control" required placeholder="Contraseña" value="brincon@megacreativo.com">
                        <span class="fa fa-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/accounts/reset_password/" class="pull-right">{Lang::get('auth.recovery')}</a>
                        </div>
                    </div>

                    <br/>
                    <div class="row">
                        <div class="pull-right">
                            <div class="col-md-12">
                                <button id="btn_acceso" type="submit" class="btn btn-info btn-block btn-flat" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {Lang::get('processing')}..."><span class="fa fa-sign-in"></span> {Lang::get('auth.enter')}</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        
        <div class="col-md-12 text-center" style="padding: 15px">
            {if $ambit=='backend'}
            <a href="/accounts/auth/">{Lang::get('auth.back')}</a>
            {else}
            <a href="/accounts/auth/backend/">{Lang::get('auth.admin')}</a>
            {/if}
        </div>
        
    </div>
    
</div>


{if $ambit=='backend'}
<script>
    var backend = 1;
</script>
{else}
<script>
    var backend = 0;
</script>
{/if}

<script>
    ExtendJS.path = '{BASE_URL}/asset/components/extendmejs/';
    npm('notify');
</script>

<script>


    var _token = '{$token|default:""}';

    $('#form-auth').submit(function(e) {

        e.preventDefault();

        $('.form-group').removeClass('has-error');

        if ( !$('#email').val().isEmail() ) {
            $('#email').focus().parent().addClass('has-error');
            ex.notify('{Lang::get("auth.email_required")}', 'error');
            return false;
        }

        if ($('#pass').val() == '') {
            $('#pass').focus().parent().addClass('has-error');
            ex.notify('{Lang::get("auth.pass_required")}', 'error');
            return false;
        }

        var $btn = $('#btn_acceso').button('loading');

        $.ajax({
            url: '/api/v1/accounts/auth/',
            data: {
                email: $('#email').val(),
                pass: $('#pass').val(),
                token: _token,
                backend: backend,
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {

                if (data.status == 200) {
                    setTimeout(function() {
                        location.href = data.default_module;
                    }, 1000);
                    $('.auth-box').fadeOut();
                    ex.notify(data.statusText, data.icon);
                } else {
                    $btn.button('reset');
                    ex.notify(data.statusText, data.icon);
                    $(data.field).focus().parent().addClass('has-error');
                    //_token = data.response.token;				
                }
            }
        });

    });
</script>