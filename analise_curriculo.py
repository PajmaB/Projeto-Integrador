import sys
import os
import io
import google.generativeai as genai
from docling.document_converter import *
from docling import *

sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def extrair_texto_pdf(caminho_arquivo_pdf):
    converter = DocumentConverter()
    resultado = converter.convert(caminho_arquivo_pdf)
    return f"{resultado.document.export_to_markdown()}"

def analisar_curriculo_com_gemini(vaga, texto_curriculo):
    # Configuração da chave API
    genai.configure(api_key="AIzaSyCtUGBV3JOBU95T1M4N9WalDrVnH8reWn8")

    # A string do prompt para a API
    prompt = f"""
    Com base na vaga de emprego descrita abaixo e no texto do currículo,
    analise a compatibilidade do candidato. Classifique a compatibilidade em
    uma escala em porcentagem, de 1% a 100% e forneça uma breve justificativa junto de recomendações sobre como melhorar o currículo para esta vaga.

    ---
    VAGA DE EMPREGO:
    {vaga}
    ---
    TEXTO DO CURRÍCULO:
    {texto_curriculo}
    ---

    Formato de resposta:
    Compatibilidade: [Nota de 1 a 10]
    Justificativa: [Breve justificativa]
    Recomendações: [Recomendações de cursos online, presenciais etc.]
    Faça uma quebra de linhas a cada 10 palavras
    """

    # Chamada da API Gemini
    model = genai.GenerativeModel('gemini-2.5-pro')
    response = model.generate_content(prompt)
    return response.text
    
def main():
    # Verifica se os argumentos foram passados corretamente
    if len(sys.argv) < 3:
        print("Erro: É necessário passar a vaga e o caminho do currículo.")
        sys.exit(1)

    vaga = sys.argv[1]
    caminho_curriculo = sys.argv[2]
    
    # Valida se o arquivo existe
    if not os.path.exists(caminho_curriculo):
        print(f"Erro: Arquivo não encontrado no caminho: {caminho_curriculo}")
        sys.exit(1)

    # Etapa 1: Extrair o texto do PDF com Docling
    texto_curriculo = extrair_texto_pdf(caminho_curriculo)

    # Etapa 2: Analisar o texto com a API Gemini
    resultado_analise = analisar_curriculo_com_gemini(vaga, texto_curriculo)

    # Etapa 3: Imprimir o resultado para que o PHP possa capturá-lo
    print(resultado_analise)

if __name__ == "__main__":
    main()
