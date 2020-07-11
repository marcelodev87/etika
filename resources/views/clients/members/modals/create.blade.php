<div class="modal fade" tabindex="-1" role="dialog" id="modal-form-cadastrar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Novo Membro</h4>
            </div>
            <form action="{{ route('app.clients.members.store', $client->id) }}" method="post" id="form-cadastrar">
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
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
