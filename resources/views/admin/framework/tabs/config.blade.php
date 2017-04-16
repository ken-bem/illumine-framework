<h2>Configuration Details</h2>
<table class="widefat">
    <thead>
    <tr>
        <th class="row-title">
            Key
        </th>
        <th>
            Value(s)
        </th>
    </tr>
    </thead>
    <tbody>

    <?php $count = count($config->all()); ?>
    @foreach($config->all() as $key => $items)

        @if(!empty($items))
            <tr @if($count % 2 == 0) class="alternate" @endif>
                <td class="row-title">
                    <label for="tablecell">
                        {{$key}}
                    </label>
                </td>
                <td>
                    @if(is_array($items))
                        @foreach($items as $key => $item)
                            {{ (is_string($key) ? ucwords($key).':' : '') }} {{$item}}<br/>
                        @endforeach
                    @else
                        {{(is_bool($items) ? var_export($items, true) : $items)}}
                    @endif
                </td>
            </tr>
        @endif
        <?php  $count--; ?>
    @endforeach
    </tbody>
</table>


