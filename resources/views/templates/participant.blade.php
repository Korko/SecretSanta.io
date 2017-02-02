<script type="text/x-template" id="participant-template">
    <tr class="participant" :id="'participant_'+idx">
        <td class="row">
            <div class="input-group">
                <span class="input-group-addon counter">@{{ idx+1 }}</span>
                <input type="text" :name="'name['+idx+']'" required="required" placeholder="@lang('form.name.placeholder')" v-model="name" class="form-control participant-name" />
            </div>
        </td>
        <td class="row border-left">
            <input type="email" :name="'email['+idx+']'" placeholder="@lang('form.email.placeholder')" v-model="email" class="form-control participant-email" :required="!phone || dearsanta" />
        </td>
        <td class="row border-right text-left participant-exclusions-wrapper">
            <select2 :name="'exclusions['+idx+'][]'" :options="participantNames" v-model="exclusions" placeholder="@lang('form.exclusions.placeholder')"></select2>
        </td>
        <td class="row participant-remove-wrapper">
            <button type="button" class="btn btn-danger participant-remove" :disabled="participants.length <= 2" @click="$emit('delete')">
                <span class="glyphicon glyphicon-minus"></span><span> @lang('form.participant.remove')</span>
            </button>
        </td>
    </tr>
</script>
