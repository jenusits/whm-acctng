
                        <!-- Table -->
                        <table class="table table-sm table-transparent table-hover">
                            <tr>
                                <th>Particulars</th>
                                <th>Accounts</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach($request_funds as $key => $request_fund)
                                <tr>
                                    <td>{!! preg_replace('/<br\\s*?\/??>/i', '', $request_fund->particulars) !!}</td>
                                    <td>
                                        <a href="{{ route('charts.show', $charts->find($request_fund->category)->id) }}">{{ $charts->find($request_fund->category)->account_name }}</a>
                                    </td>
                                    <td>
                                        @if($request_fund->approved)
                                            Approved
                                        @else
                                            Pending
                                        @endif
                                    </td>
                                    <td>
                                        <a style="margin: 5px; font-size: 10px" href="{{ route('request_funds.show', $request_fund->id) }}" class="btn btn-success"><i class="fas fa-search"></i></a>
                                        <a style="margin: 5px; font-size: 10px" href="{{route('request_funds.edit', $request_fund->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{route('request_funds.destroy', $request_fund->id)}}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                            </tr>
                        </table>