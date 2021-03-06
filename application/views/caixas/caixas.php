<div class="new122" style="margin-top: 0; min-height: 100vh">
    <div class="flexxn" style="display: flex;">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aServico')) { ?>
            <a href="<?php echo base_url(); ?>index.php/caixas/adicionar?abre=1" class="button btn btn-mini btn-success" style="max-width: 160px">
                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Abrir Caixa</span></a>
            <a href="<?php echo base_url(); ?>index.php/caixas/adicionar?fecha=1" class="button btn btn-mini btn-success" style="max-width: 160px">
                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Fechar Caixa</span></a>
            <a href="<?php echo base_url(); ?>index.php/caixas/adicionar?mov=1" class="button btn btn-mini btn-success" style="max-width: 160px">
                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Add. Movimentação</span></a>
    </div>

<?php } ?>

<div class="widget-box">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-wrench"></i>
        </span>
        <h5>Caixas</h5>
    </div>
    <div class="widget-content nopadding tab-content">
        <table id="tabela" class="table table-bordered ">
            <thead>
                <tr>
                    <th>Cod.</th>
                    <th>Data</th>
                    <th>Histórico</th>
                    <th>Descrição</th>
                    <th>Operador</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$results) {
                    echo '<tr>
                                <td colspan="5">Nenhum Caixa Cadastrado</td>
                              </tr>';
                }
                foreach ($results as $r) {
                    $dataCaixa = date(('d/m/Y'), strtotime($r->data));
                    echo '<tr>';
                    echo '<td>' . $r->idCaixas . '</td>';
                    echo '<td>' . $dataCaixa . '</td>';
                    echo '<td>' . $r->historico . '</td>';
                    echo '<td>' . $r->descricao . '</td>';
                    echo '<td>' . $r->operador . '</td>';
                    echo '<td>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')) {
                        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/caixas/editar/' . $r->idCaixas . '" class="btn-nwe3" title="Editar Caixa"><i class="bx bx-edit bx-xs"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')) {
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" caixa="' . $r->idCaixas . '" class="btn-nwe4" title="Excluir Caixa"><i class="bx bx-trash-alt bx-xs"></i></a>  ';
                    }
                    echo '</td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php echo $this->pagination->create_links(); ?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/caixas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Caixa</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCaixa" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este caixa?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var caixa = $(this).attr('caixa');
            $('#idCaixa').val(caixa);
        });
    });
</script>