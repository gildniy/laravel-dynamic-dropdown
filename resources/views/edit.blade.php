@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Author Edit</div>

                    <div class="panel-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('test.update', $author->id )}} " accept-charset="UTF-8"
                              class="form-horizontal panel">

                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="PUT">

                            <div class="form-group ">
                                <label for="name" class="col-md-4 control-label">Name :</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="name" type="text" id="name"
                                           value="{{ old('name', $author->name) }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country" class="col-md-4 control-label">Country :</label>
                                <div class="col-md-6">
                                    <select name="country" id="country" class="form-control">
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="col-md-4 control-label">City :</label>
                                <div class="col-md-6">
                                    <select name="city" id="city" class="form-control"></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {

            // Get IDs for countries and cities
            var country_id = {{ old('country', $author->city->country->id) }};
            var city_id = {{ old('city', $author->city->id) }};

            // Country select
            $('#country').val(country_id).prop('selected', true);
            // Sync of cities
            cityUpdate(country_id);

            // Country change event
            $('#country').on('change', function (e) {
                var country_id = e.target.value;
                city_id = false;
                cityUpdate(country_id);
            });

            // Requête Ajax pour les villes
            // Ajax Request for cities
            function cityUpdate(countryId) {
                $.get('{{ url('cities') }}/' + countryId + "'", function (data) {
                    $('#city').empty();
                    $.each(data, function (index, cities) {
                        $('#city').append($('<option>', {
                            value: cities.id,
                            text: cities.name
                        }));
                    });
                    if (city_id) {
                        $('#city').val(city_id).prop('selected', true);
                    }
                });
            }

        });
    </script>
@endsection