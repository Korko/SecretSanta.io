@extends('templates/layout', ['styles' => '/assets/randomForm.css'])

@section('header')
    @parent

    <!-- config js -->
    @javascript([
        'now'    => time()
    ])
@stop

@section('navbar')
                <li><a href="#what">@lang('form.nav.what')</a></li>
                <li><a href="#how">@lang('form.nav.how')</a></li>
                <li><a href="#form">@lang('form.nav.go')</a></li>

                <li class="btn-group btn-group-xs dropdown">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="lang-xs lang-lbl" lang="{{ App::getLocale() }}"></span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        @foreach(array_diff_key(config('app.domains'), [App::getLocale() => '']) as $locale => $domain)
                            <li><a href="https://{{ $domain }}"><span class="lang-sm lang-lbl" lang="{{ $locale }}"></span></a></li>
                        @endforeach
                    </ul>
                </li>
@stop

@section('body')
    <div id="header">
        <div class="bg-overlay"></div>
        <div class="center text-center">
            <div class="banner">
                <h1 class="">Secret Santa</h1>
            </div>
            <div class="subtitle"><h4>@lang('form.subtitle')</h4></div>
        </div>
        <div class="bottom text-center">
            <a id="scrollDownArrow" href="#"><i class="fa fa-chevron-down"></i></a>
        </div>
    </div>
    <!-- /#header -->

    <div id="what" class="light-wrapper">
        <section class="ss-style-top"></section>
        <div class="container inner">
            <h2 class="section-title text-center">@lang('form.section.what.title')</h2>
            <p class="lead main text-center">@lang('form.section.what.subtitle')</p>
            <div class="row text-center what">
                <ul class="media-list">
                    <li class="media">
                        <div class="media-left media-middle">
                            <img class="media-object" src="assets/img/calendar-icon.png" />
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@lang('form.section.what.heading1')</h4>
                            <p>{!! nl2br(trans('form.section.what.content1')) !!}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.container -->
        <section class="ss-style-bottom"></section>
    </div><!-- #what -->

    <div class="parallax">
        <div class="container inner">

        </div>
        <!-- /.container -->
    </div><!-- #spacer1 -->

    <div id="how" class="light-wrapper">
        <section class="ss-style-top"></section>
        <div class="container inner">
            <h2 class="section-title text-center">@lang('form.section.how.title')</h2>
            <p class="lead main text-center">@lang('form.section.how.subtitle')</p>
            <div class="row text-center how">
                <ul class="media-list">
                    <li class="media">
                        <div class="media-left media-middle">
                            <img class="media-object" src="assets/img/user-icon.png" />
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@lang('form.section.how.heading1')</h4>
                            <p>{!! nl2br(trans('form.section.how.content1')) !!}</p>
                        </div>
                    </li>
                    <li class="media">
                        <div class="media-body">
                            <h4 class="media-heading">@lang('form.section.how.heading2')</h4>
                            <p>{!! nl2br(trans('form.section.how.content2')) !!}</p>
                        </div>
                        <div class="media-right media-middle">
                            <img class="media-object" src="assets/img/paper-icon.png" />
                        </div>
                    </li>
                    <li class="media">
                        <div class="media-left media-middle">
                            <img class="media-object" src="assets/img/mail-icon.png" />
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@lang('form.section.how.heading3')</h4>
                            <p>{!! nl2br(trans('form.section.how.content3')) !!}</p>
                        </div>
                    </li>
                </ul>
                <div class="well well-lg">{!! nl2br(trans('form.section.how.notice', ['link' => '<a href="https://github.com/Korko/SecretSanta">GitHub</a>'])) !!}</div>
            </div>
        </div>
        <!-- /.container -->
        <section class="ss-style-bottom"></section>
    </div><!--/#how-->

    <div class="parallax parallax2">
        <div class="container inner">

        </div>
        <!-- /.container -->
    </div><!-- #spacer1 -->

    @include('templates/participant')
    <div id="form" class="light-wrapper" v-cloak>
        <section class="ss-style-top"></section>
        <div class="container inner">
            <h2 class="section-title text-center">@lang('form.section.go.title')</h2>
            <p class="lead main text-center">@lang('form.section.go.subtitle')</p>
            <div class="row text-center form">
                <div id="success-wrapper" class="alert alert-success" v-show="sent">
                    @lang('form.success')
                </div>

                <div id="errors-wrapper" class="alert alert-danger" v-show="errors.length && !sent">
                    <ul id="errors">
                        <li v-for="error in errors">@{{ error }}</li>
                    </ul>
                </div>

                <form action="{{ url('/') }}" @submit.prevent="submit" method="post" autocomplete="off">
                    <fieldset :disabled="sending || sent">
                        <fieldset>
                            <legend>@lang('form.participants')</legend>
                            <div class="table-responsive form-group">
                                <table id="participants" class="table table-hover table-striped table-numbered">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-4">@lang('form.participant.name')</th>
                                            <th class="col-lg-4">@lang('form.participant.email')</th>
                                            <th class="col-lg-2">@lang('form.participant.exclusions')</th>
                                            <th class="col-lg-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Default is three empty rows to have three entries at any time --}}
                                        <tr is="participant" v-for="(participant, idx) in participants" :key="participant.id"
                                            :participants="participants"
                                            :dearsanta="dearsanta"
                                            :idx="idx"
                                            @changename="participant.name = $event"
                                            @changeemail="participant.email = $event"
                                            @delete="participants.splice(idx, 1)">
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success participant-add" @click="addParticipant()"><span class="glyphicon glyphicon-plus"></span> @lang('form.participant.add')</button>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Messages</legend>
                            <div class="row" id="contact">
                                <fieldset id="form-mail-group" :disabled="!this.emailUsed">
                                    <div class="form-group">
                                        <label for="mailTitle">@lang('form.mail.title')</label>
                                        <input id="mailTitle" type="text" name="title" :required="this.emailUsed" placeholder="@lang('form.mail.title.placeholder')" value="" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="mailContent">@lang('form.mail.content')</label>
                                        <textarea id="mailContent" name="contentMail" :required="this.emailUsed" placeholder="@lang('form.mail.content.placeholder')" class="form-control" rows="3" v-autosize></textarea>
                                        <textarea id="mailPost" class="form-control" read-only disabled v-if="!dearsanta">@lang('form.mail.post')</textarea>
                                        <textarea id="mailPost" class="form-control extended" read-only disabled v-else>@lang('form.mail.post2')</textarea>
                                        <p class="help-block">@lang('form.mail.content.tip1')</p>
                                        <p class="help-block">@lang('form.mail.content.tip2')</p>
                                    </div>
                                </fieldset>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Options</legend>
                            <div id="form-options" class="form-group">
                                <label><input type="checkbox" name="dearsanta" v-model="dearsanta" value="1"/> Autoriser les participants à écrire un mail à leur secret santa</label>
                                <label><input type="date" name="dearsanta-expiration" :min="date | moment(1, 'day')" :max="date | moment(1, 'year')" :disabled="!dearsanta" /> Date limite de stockage des emails</label>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group btn">
                                {!! Recaptcha::renderElement(['data-theme' => 'light']) !!}
                            </div>

                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-lg">
                                <span v-if="sending"><span class="glyphicon glyphicon-refresh spinning"></span> @lang('form.sending')</span>
                                <span v-if="sent"><span class="glyphicon glyphicon-ok"></span> @lang('form.sent')</span>
                                <span v-else>@lang('form.submit')</span>
                            </button>
                        </fieldset>
                    </fieldset>
                </form>

            </div>
            <!-- /.services -->
        </div>
        <!-- /.container -->
    </div>
@stop

@section('copyright')
    @parent

    <br/>{!! trans('footer.icons', ['author' => '<a class="themeBy" href="https://www.iconfinder.com/iconsets/doublejdesign-free-icon-handy_color">Double-J Designs</a>']) !!}
@stop

@section('script')
    <script type="text/javascript" src="{{ URL::asset('assets/randomForm.js') }}"></script>

    {!! Recaptcha::renderScript(App::getLocale()) !!}

    @if(Session::has('message'))
    <script type="text/javascript">
        alertify.alert("{{ session('message') }}");
    </script>
    @endif
@stop
