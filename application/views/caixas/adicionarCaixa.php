<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-wrench"></i>
                </span>
                <h5>Abertura de Caixa</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formCaixa" method="post" class="form-horizontal">
                    <div class="control-group">
                        <label for="data" class="control-label">Data<span class="required">*</span></label>
                        <div class="controls">
                            <input id="data" type="text" name="data" value="<?php echo date('d/m/Y'); ?>" readonly />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="historico" class="control-label"><span class="required">Histórico*</span></label>
                        <div class="controls">
                            <input id="historico" class="money" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="historico" value="<?php echo set_value('historico'); ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição</label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="operador" class="control-label">Operador</label>
                        <div class="controls">
                            <input id="operador" type="text" name="operador" value="<?php echo set_value('operador'); ?>" />
                            <input id="operador_id" hidden="true" type="text" name="operador_id" value="<?php echo set_value('operador_id'); ?>" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3" style="display:flex;justify-content: center">
                                <button type="submit" class="button btn btn-mini btn-success" style="max-width: 160px">
                                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Adicionar</span></a></button>
                                <a href="<?php echo base_url() ?>index.php/servicos" id="btnAdicionar" class="button btn btn-mini btn-warning" style="max-width: 160px">
                                    <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".money").maskMoney();
        $('#formServico').validate({
            rules: {
                nome: {
                    required: true
                },
                preco: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: 'Campo Requerido.'
                },
                preco: {
                    required: 'Campo Requerido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
</script>