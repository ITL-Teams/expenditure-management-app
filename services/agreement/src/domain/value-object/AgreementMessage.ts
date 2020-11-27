import { InvalidArgumentError } from '../error/InvalidArgumentError'

export class AgreementMessage {
  private readonly agreementMessage: string

  constructor(agreementMessage: string) {
    this.agreementMessage = agreementMessage
    this.ensureNameOnlyContainsLetters(agreementMessage)
  }

  private ensureNameOnlyContainsLetters(value: string): void {
    const valid_word = /^([a-zA-Z\s\-',|();:.0-9!"#$%&><¡!?¿*+{}=\[\]])+$/

    if (valid_word.test(value)) return

    throw new InvalidArgumentError(`${value} is not valid message`)
  }

  public toString(): string {
    return `${this.agreementMessage}`
  }
}
