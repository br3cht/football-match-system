<div>
 <div class="shop-container" style="display: flex;">
      <div class="container mx-auto px-4 py-6">
        <div class="flex gap-4">
            <!-- Sidebar de Categorias -->
            <aside class="w-1/4 bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Competições</h3>
                <ul>
                    @foreach($competitions as $competition)
                        <li class="mb-2">
                            <a href="#"
                               wire:click.prevent="getMatches({{ optional($competition)['id']}}, {{optional($competition)['current_matchday'] ?? 0}})"
                               class="block px-3 py-2 rounded hover:bg-gray-200 transition-colors {{ $competitionSelected == $competition['id'] ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                               {{ $competition['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>
            <!-- Tabela de Jogos da Rodada Atual -->
                <div class="w-3/4 bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Jogos da Rodada {{ $rounds }}</h3>

                    @if(count($matches) > 0)
                        <!-- Botões para alternar entre rodadas -->
                        <div class="flex justify-between mb-4">
                            <button
                                wire:click="showPreviousRound"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50">
                                Rodada Anterior
                            </button>
                            <button
                                wire:click="showNextRound()"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Próxima Rodada
                            </button>
                        </div>
                    @endif

                    @if($matches && count($matches) > 0)
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="border-b">
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matches as $match)
                                    <tr class="border-b">
                                         <td class="px-4 py-2">
                                        <!-- Exibindo a imagem do time 1 -->
                                            <img src="{{ $match['home_team_logo'] }}" alt="{{ $match['home_team'] }}" class="w-12 h-12 object-cover rounded-full">
                                        </td>
                                        <td class="px-4 py-2">{{ $match['home_team'] }}</td>
                                        <td class="px-4 py-2">{{ $match['home_team_score'] }} x {{ $match['away_team_score'] }}</td>
                                         <td class="px-4 py-2">
                                        <!-- Exibindo a imagem do time 1 -->
                                            <img src="{{ $match['away_team_logo'] }}" alt="{{ $match['away_team'] }}" class="w-12 h-12 object-cover rounded-full">
                                        </td>
                                        <td class="px-4 py-2">{{ $match['away_team'] }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($match['date'])->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-700">Nenhum jogo encontrado para esta competição.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

