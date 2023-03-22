@extends('layout')

@section('contenu')
    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-primary text-uppercase" aria-current="page">GESTIONS DES ACTIFS FINANCIERS</li>
        </ol>
    </nav>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <form action="{{isset($position) ? route("actifs.update",$position->id_actifs_financiers) : route("actifs.create")}}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-uppercase text-primary">Informations  ACTIFS FINANCIERS</h6>
            </div>
            <div class="container-fluid mt-3">

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold text-uppercase" for="symbole">nom</label>
                        <input type="text" class="form-control font-weight-bold text-uppercase" id="nom" name="nom"  value="{{isset($position) ? $position->nom : ''}}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold text-uppercase" for="quantite">symbole boursier </label>
                        <input type="text" class="form-control font-weight-bold text-uppercase" id="symbole_boursier" name="symbole_boursier"  value="{{isset($position) ? $position->symbole_boursier : ''}}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold text-uppercase" for="quantite">categorie </label>
                        <input type="text" class="form-control font-weight-bold text-uppercase" id="categorie" name="categorie"  value="{{isset($position) ? $position->categorie : ''}}" required>
                    </div>
                </div>







                <div align="right">
                    <a href="{{route('actifs.index')}}" class="btn btn-danger text-uppercase">Retour</a>
                    <button  class="btn btn-warning text-uppercase" type="reset">Annuler</button>
                    <button id="demande_enregistrer" class="btn btn-primary text-uppercase"  type="submit">{{isset($position) ? 'Modifier' : 'Enregistrer'}}</button>
                </div>
                <br>
            </div>
        </div>


    </form>

    <form method="post" action="{{route('actifs.delete')}}">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-uppercase text-primary">Listes des actifs financiers</h6>
            </div>
            <div class="card-body">

                <table class="table table-striped table-bordered w-100" style="font-size: 16px">
                    <thead>
                    <tr class="bg-indigo text-black-50 w-100 text-uppercase font-weight-bold">
                        <th></th>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Symbole</th>
                        <th>Catégorie</th>


                    </tr>

                    </thead>


                    <tbody class="text-black text-uppercase font-weight-bold">
                    @foreach($list_actifs as $item)
                        <tr>
                            <td align="center"><input type="checkbox" id="cocher[]" name="cocher[]"
                                                      value="{{$item->id_actifs_financiers}}"></td>
                            <td><a href="{{route('actifs.edit',$item->id_actifs_financiers)}}">{{$item->id_actifs_financiers}}</a></td>
                            <td>{{$item->nom}}</td>
                            <td>{{$item->symbole_boursier}}</td>
                            <td>{{$item->categorie}}</td>
                        </tr>


                    @endforeach

                    </tbody>
                </table>

                <div align="right"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#DeleteEvaluationModal"
                                      style="margin: 20px;"><i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer la sélection</a>
                </div>

            </div>



        </div>


        <div class="modal fade" id="DeleteEvaluationModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer la sélection
                            ?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Cliquez sur le bouton "Supprimer" ci-dessous si vous voulez supprimer les
                        éléments sélectionnés.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                        <button type="submit" class="btn btn-danger" name="supprimer"><i
                                class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>


@endsection
