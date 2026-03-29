# **Datamorpho Short FAQ**

## **1\. Is Datamorpho steganography?**

No. Datamorpho requires a public declaration that hidden states exist. That is fundamentally different from a system designed to deny or conceal the existence of hidden content.

## **2\. Does Datamorpho require one algorithm for the whole file?**

No. A single hidden state may use different cryptographic suites across different fragments, and different states may use different combinations.

## **3\. Does the reconstruction object contain the key?**

In v0.001, yes. The reconstruction object is a complete secret-bearing artifact and may include the key material needed to reconstruct the target hidden state.

## **4\. Does Datamorpho require states to be sequential?**

No. States can be treated as an unordered set. They do not need to follow a linear release sequence.

## **5\. Can bytes from different states coexist in the same payload region?**

Yes. In Datamorpho, the same payload region may contain bytes relevant to different states, along with chaff.

## **6\. Is Datamorpho limited to NFTs?**

No. NFTs are only one important use case. Datamorpho is also relevant for games, publishing, archives, financial workflows, auctions, documents, news releases, and staged media.

## **7\. Why allow `sparse` without chaff?**

Because in some large-file or bandwidth-sensitive deployments, sparse non-contiguous layout may already be sufficient while avoiding payload growth and transfer overhead.

## **8\. Does Datamorpho standardize viewers or trigger execution?**

No. Datamorpho v0.001 standardizes the file structure and reconstruction semantics, not every possible viewer or trigger-validation mechanism.

## **9\. Why start with JPEG, TXT, and PDF?**

Because they give a strong initial set of carriers across media, text, and structured documents.

## **10\. Why is the version 0.001 and not 0.002?**

Because this is the first formal open specification release. The 2022 ETHGlobal Mexico 2022 project is the origin story and prototype lineage, not a prior published normative spec.