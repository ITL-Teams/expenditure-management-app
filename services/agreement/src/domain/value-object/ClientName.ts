import { InvalidArgumentError } from '../error/InvalidArgumentError'

export class ClientName {
  private readonly clientName: string

  constructor(clientName: string) {
    this.clientName = clientName
    this.ensureNameOnlyContainsLetters(clientName)
  }

  private ensureNameOnlyContainsLetters(value: string): void {
    const valid_word = /^([a-zA-Z\s'])+$/

    if (valid_word.test(value)) return

    throw new InvalidArgumentError(`${value} is not valid name`)
  }

  public toString(): string {
    return `${this.clientName}`
  }
}
