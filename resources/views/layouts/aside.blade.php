<aside class="main-sidebar dark-bg">
    <section class="sidebar">
        <div class="user-panel black-bg">
            <div class="pull-left image">
                <img
                    src="{!! getAvatar(auth()->user()->id)!!}"
                    class="img-circle appUserAvatar" alt="User Image">
            </div>
            <div class="pull-left info">
                <p class="appUserName">{{auth()->user()->name}}</p>
            </div>
        </div>

        {{-- Sidebar Menu --}}
        <ul class="sidebar-menu tree" data-widget="tree">


            @if(auth()->user()->hasAnyRole(['adm']))
                <li class="header dark-bg">Módulos</li>
                <li>
                    <a href="{!! route('app.processes.index') !!}">
                        <i class="fa fa-clipboard-check"></i> <span>Processos</span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('app.tasks.index') !!}">
                        <i class="fa fa-check-circle"></i> <span>Tarefas</span>
                    </a>
                </li>
                <li>
                    <a href="{!! route('app.notaryAddresses.index') !!}">
                        <i class="fa fa-warehouse"></i> <span>Catórios</span>
                    </a>
                </li>

                <li>
                    <a href="{!! route('app.subscriptions.index') !!}">
                        <i class="fa fa-file-signature"></i> <span>Assinaturas</span>
                    </a>
                </li>
            @endif


            <li class="header dark-bg">Menu</li>

            <li>
                <a href="{!! route('app.index') !!}">
                    <i class="fa fa-tachometer-alt"></i> <span>Painel</span>
                </a>
            </li>

            @if (auth()->user()->hasAnyRole(['adm']))
                <li>
                    <a href="{!! route('app.users.index') !!}">
                        <i class="fa fa-user-secret"></i> <span>Usuários</span>
                    </a>
                </li>
            @endif

            @if(auth()->user()->hasAnyRole(['adm']))
                <li>
                    <a href="{!! route('app.clients.index') !!}">
                        <i class="fa fa-users"></i> <span>Clientes</span>
                    </a>
                </li>
            @endif


            @if(auth()->user()->hasAnyRole(['adm']))
                <li class="treeview {{ menuPath(['app.documents.ataFuncao', 'app.documents.estatutoEspecial'], 'menu-open') }}">
                    <a href="javascript:void(0)">
                        <i class="fa fa-copy"></i><span>Geração de Documentos</span>
                        <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                    </a>
                    <ul class="treeview-menu" {{ (menuPath(['app.documents.ataFuncao', 'app.documents.estatutoEspecial'])) ? 'style=display:block' : null }} >
                        <li>
                            <a href="{{ route('app.documents.ataFuncao') }}">Ata de Função</a>
                        </li>
                        <li>
                            <a href="{{ route('app.documents.estatutoEpiscopal') }}">Estatuto Episcopal</a>
                        </li>
                        <li>
                            <a href="{{ route('app.documents.contratoAbertura') }}">Contrato Abertura</a>
                        </li>
                        <li>
                            <a href="{{ route('app.documents.contratoContabil') }}">Contrato Contábil</a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>

    </section>
</aside>
