#!/usr/bin/env python

# Import necessary modules and classes for document loading, text splitting, embedding, and vector storage
from langchain.document_loaders import PyPDFLoader
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.embeddings import BedrockEmbeddings
from langchain.vectorstores.pgvector import PGVector
# from dotenv import load_dotenv
# import os

# Load environment variables from a .env file
# load_dotenv()

# Define the file path for the PDF document
file_path = '/var/www/storage/app/vector-stores/QIrZVaik98.1714808567.pdf'

print(file_path)
# # Initialize a loader for PDF documents
# loader = PyPDFLoader(file_path=file_path)
#
# # Initialize a text splitter for dividing text into chunks
# text_splitter = RecursiveCharacterTextSplitter(chunk_size=2000, chunk_overlap=100)
#
# # Load and split the document
# data = loader.load_and_split(text_splitter=text_splitter)
#
# # Define the collection name for storing embeddings
# COLLECTION_NAME = "eslbook"
#
# # Construct the connection string to the PostgreSQL database
# CONNECTION_STRING = PGVector.connection_string_from_db_params(
#     driver=postgresql,
#     user='python-user',
#     password='kuHJ|*ynT5$9',
#     host='192.168.93.40',
#     port=5432,
#     database='vector_store',
# )
#
# # Initialize the text embedding model
# embeddings = BedrockEmbeddings()
#
# # Create a vector database store instance and populate it with document data and embeddings
# db = PGVector.from_documents(
#     documents=data,
#     embedding=embeddings,
#     collection_name=COLLECTION_NAME,
#     connection_string=CONNECTION_STRING
# )
