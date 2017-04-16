<h2>Cache Management</h2>

<table class="widefat">
    <thead>
    <tr>
        <th class="row-title">
            Storage Type
        </th>
        <th>
            Disk Usage
        </th>
        <th>
            Management
        </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td class="row-title">
                <label for="tablecell">
                    Session Storage
                </label>
            </td>
            <td>
                {!! $sessions_size !!}
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_flush" value="sessions">
                    <button type="submit" value="submit" class="button">Flush</button>
                </form>
            </td>
        </tr>
        <tr class="alternate">
            <td class="row-title">
                <label for="tablecell">
                    Eloquent Collection Cache
                </label>
            </td>
            <td>
                {!! $objects_size !!}
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_flush" value="objects">
                    <button type="submit" value="submit" class="button">Flush</button>
                </form>
            </td>
        </tr>
        <tr>
            <td class="row-title">
                <label for="tablecell">
                    Route Collection Cache
                </label>
            </td>
            <td>
                {!! $routes_size !!}
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_flush" value="routes">
                    <button type="submit" value="submit" class="button">Flush</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td class="row-title">
                <label for="tablecell">
                    Blade Template Cache
                </label>
            </td>
            <td>
                {!! $views_size !!}
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_flush" value="views">
                    <button type="submit" value="submit" class="button">Flush</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>

<p><small>**Caches will regenerate themselves automatically according to your configuration file.</small></p>



