import { useState } from "react";
import ContatoList from "./ContatoList";
import PessoaList from "./PessoaList";

const App = () => {
  const [selectedPessoa, setSelectedPessoa] = useState(null);
  const [contatos, setContatos] = useState([]);

  const handleSelectPessoa = (pessoa) => {
    setSelectedPessoa(pessoa);
    fetch(`http://localhost:8000/contatos/${pessoa.id}`)
      .then((response) => response.json())
      .then((data) => setContatos(data));
  };

  return (
    <div className="flex justify-center p-8">
      <PessoaList onSelectPessoa={handleSelectPessoa} />
      <ContatoList
        contatos={contatos}
        setContatos={setContatos}
        selectedPessoa={selectedPessoa}
      />
    </div>
  );
};

export default App;
