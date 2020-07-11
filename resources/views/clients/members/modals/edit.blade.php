<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar</h4>
            </div>
            <form method="post" action="" id="modal-form-edit">
                @method('put')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-xs-12 col-md-sm-6 col-md-8 col-lg-8">
                            <fieldset class="form-group">
                                <label>Nome Completo</label>
                                <input class="form-control" name="name" type="text">
                            </fieldset>
                        </div>

                        <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-4">
                            <fieldset class="form-group">
                                <label>Documento</label>
                                <input class="form-control" name="document" type="text" data-mask="000.000.000-00">
                            </fieldset>
                        </div>

                        <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                            <fieldset class="form-group">
                                <label>Cargo</label>
                                <input class="form-control" name="role" type="text">
                            </fieldset>
                        </div>

                        <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                            <fieldset class="form-group">
                                <label>Sexo</label>
                                <select class="form-control" name="gender">
                                    <option value="">Selecione</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Masculino">Masculino</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                            <fieldset class="form-group">
                                <label>Estado Civil</label>
                                <input class="form-control" name="marital_status" type="text">
                            </fieldset>
                        </div>

                        <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                            <fieldset class="form-group">
                                <label>Profissão</label>
                                <input class="form-control" name="profession" type="text">
                            </fieldset>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-sync"></i> Alterar
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
