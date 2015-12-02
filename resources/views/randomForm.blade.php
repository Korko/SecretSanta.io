<!DOCTYPE html>
<html>
    <head>
        <title>Secret Santa Sorter</title>
        <style>
            .participant:nth-child(-n+2) a.remove {display: none}
        </style>
        <script type="text/javascript" src="{{ url('media/js/randomForm.js') }}"></script>
    </head>
    <body>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="" method="post" autocomplete="off">
            {{ csrf_field() }}
            <fieldset>
                <legend>Participants Details</legend>
                <table id="participants">
                    <thead>
                        <tr>
                            <th>Name or Surname</th>
                            <th>Email</th>
                            <th>Remove line</th>
                            <th>Partner (will not be the target)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="participant">
                            <td>
                                <input type="text" name="name[]" required="required" placeholder="Name Surname" onblur="updateParticipant(event.target.parentNode.parentNode)" />
                            </td>
                            <td>
                                <input type="email" name="email[]" required="required" placeholder="Email" />
                            </td>
                            <td>
                                <a href="" class="remove" onclick="removeParticipant(event.target.parentNode.parentNode);return false;">
                                    <img src="https://cdn1.iconfinder.com/data/icons/realistiK-new/16x16/actions/edit_remove.png" />
                                </a>
                            </td>
                            <td>
                                <select name="partner[]" onchange="updatePartner(event.target.parentNode.parentNode);">
                                    <option value="" disabled="disabled" selected="selected">Partner</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="participant">
                            <td>
                                <input type="text" name="name[]" required="required" placeholder="Name Surname" onblur="updateParticipant(event.target.parentNode.parentNode)" />
                            </td>
                            <td>
                                <input type="email" name="email[]" required="required" placeholder="Email" />
                            </td>
                            <td>
                                <a href="" class="remove" onclick="removeParticipant(event.target.parentNode.parentNode);return false;">
                                    <img src="https://cdn1.iconfinder.com/data/icons/realistiK-new/16x16/actions/edit_remove.png" />
                                </a>
                            </td>
                            <td>
                                <select name="partner[]" onchange="updatePartner(event.target.parentNode);">
                                    <option value="" disabled="disabled" selected="selected">Partner</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="" onclick="addParticipant();return false;"><img src="https://cdn2.iconfinder.com/data/icons/splashyIcons/add_small.png" alt="+" title="Add new participant" /></a><br />
                <br />
                <p><label>Mail Title<br /><input type="text" name="title" required="required" /></label></p>
                <p><label>Mail Content (use "{SANTA}" for santa's name and "{TARGET}" for the target's name)<br /><textarea name="content" required="required"></textarea></label></p>
                <input type="submit" name="submit" value="Randomize" />
            </fieldset>
        </form>

    </body>
</html>
